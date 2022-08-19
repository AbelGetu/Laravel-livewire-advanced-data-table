<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    const STATUSES = [
        'success' => 'Success',
        'failed' => 'Failed',
        'processing' => 'Processing'
    ];

    protected $fillable = ['title', 'amount', 'date', 'status'];
    protected $casts = ['date' => 'date'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getStatusColorAttribute()
    {
        return [
            'success' => 'green',
            'failed' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function getDateForHumansAttribute()
    {
        return $this->date->format('M, d Y');
    }

    public function getDateForEditingAttribute()
    {
        return $this->date->format('m/d/Y');
    }

    public function setDateForEditingAttribute($value)
    {
        $this->date = Carbon::parse($value);
        // return $this->date->format('m/d/y');
    }
}
