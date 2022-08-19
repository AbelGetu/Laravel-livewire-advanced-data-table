<?php

namespace App\Http\Livewire\DataTable;


trait WithSorting
{
    public $sortField = 'title';
    public $sortDirection = 'asc';

    
     // One dimensional sorting
    public function sortBy($field)
    {
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function applySorting($query)
    {
        return $query->orderBy($this->sortField, $this->sortDirection);
    }
}