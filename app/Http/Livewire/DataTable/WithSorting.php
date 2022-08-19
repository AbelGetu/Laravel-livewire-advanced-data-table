<?php

namespace App\Http\Livewire\DataTable;


trait WithSorting
{
    // One dimensional sorting
    // public $sortField = 'title';
    // public $sortDirection = 'asc';

    
    // public function sortBy($field)
    // {
    //     if($this->sortField === $field) {
    //         $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    //     } else {
    //         $this->sortDirection = 'asc';
    //     }
    //     $this->sortField = $field;
    // }

    // public function applySorting($query)
    // {
    //     return $query->orderBy($this->sortField, $this->sortDirection);
    // }

    public $sorts = [];

    public function sortBy($field)
    {
        if(! isset($this->sorts[$field]))  return $this->sorts[$field] = 'asc';

        if($this->sorts[$field] === 'asc') return $this->sorts[$field] = 'desc';

        unset($this->sorts[$field]);
    }

    public function applySorting($query)
    {
        foreach($this->sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}