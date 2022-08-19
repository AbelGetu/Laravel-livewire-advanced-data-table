<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class Dashboard extends Component
{
    use WithPerPagePagination, WithSorting;   
   
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $selectPage = false;
    public $selectAll = false;
    public $selected = []; 
    public $filters = [
        'search' => '',
        'status' => '',
        'amount-min' => null,
        'amount-max' => null,
        'date-max' => null,
        'date-min' => null
    ];
    public Transaction $editing;

    protected $queryString = [];

    protected $listeners = ['refreshTransactions' => '$refresh'];


    public function mount()
    {
        $this->editing = $this->makeBlankTransaction();
    }
    // protected $rules = [
    //     'editing.title' => 'required|min:3',
    //     'editing.amount' => 'required',
    //     'editing.status' => 'required',
    //     'editing.date' => 'required',
    // ];

    public function rules()
    {
       return [
            'editing.title' => 'required|min:3',
            'editing.amount' => 'required',
            'editing.status' => 'required|in:'.collect(Transaction::STATUSES)->keys()->implode(','),
            'editing.date' => 'required',
        ];
    }

    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function updatedSelectPage($value)
    {
        $this->selected = $value ?   $this->selected = $this->transactions->pluck('id')->map(fn($id) => (string) $id) : [];
        
    }

    public function selectAll()
    {
        $this->selectAll = true;
    }
    

    // One dimensional sorting
    // public function sortBy($field)
    // {
    //     if($this->sortField === $field) {
    //         $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    //     } else {
    //         $this->sortDirection = 'asc';
    //     }
    //     $this->sortField = $field;
    // }

    public function updatedFilters() 
    { 
        $this->resetPage(); 
    }

    public function create()
    {
        if($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->showEditModal = true;
    }

    public function deleteSelected()
    {
       (clone $this->transactionsQuery)
                ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected))->delete();

        $this->showDeleteModal = false;
    }

    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo  (clone $this->transactionsQuery)
                            ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected))->toCsv();
        }, 'transactions.csv');
    }

    public function makeBlankTransaction()
    {
        return Transaction::make(['date' => now(), 'status' => 'success']);
    }

    // Option One
    // public function edit($transactionId)
    // {
    //     $this->editing = Transaction::find($transactionId);
    //     $this->showEditModal = true;
    // }

    public function edit(Transaction $transaction)
    {
        if($this->editing->isNot($transaction)) $this->editing = $transaction;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getTransactionsQueryProperty()
    {
        $query = Transaction::query()
        ->when($this->filters['status'], fn($query, $status) => $query->where('status', $status))
        ->when($this->filters['amount-min'], fn($query, $amountMin) => $query->where('amount', '>=' , $amountMin))
        ->when($this->filters['amount-max'], fn($query, $amountMax) => $query->where('amount', '<=' , $amountMax))
        ->when($this->filters['date-min'], fn($query, $dateMin) => $query->where('date', '>=' , Carbon::parse($dateMin)))
        ->when($this->filters['date-max'], fn($query, $dateMax) => $query->where('date', '<=' , Carbon::parse($dateMax)))
        ->when($this->filters['search'], fn($query, $search) => $query->where('title' , 'like', '%' . $search . '%'));

        return $this->applySorting($query);
        
    }
    
    public function getTransactionsProperty()
    {
        return $this->applyPagination($this->transactionsQuery);
    }

    public function render()
    {
        if($this->selectAll) {
            $this->selected = $this->transactions->pluck('id')->map(fn($id) => (string) $id);
        }

        return view('livewire.dashboard', [
            'transactions' => $this->transactions
        ]);
    }
}
