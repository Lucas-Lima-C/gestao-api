<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'title', 'date_of_conclusion', 'status'
    ];

    protected $appends = [
        'status'
    ];

    /**
     * Method to get Status Attribute
     *
     * @return string
     */
    public function getStatusAttribute()
    {

        return ($this->attributes['status'] == 'Concluido') ? 'Concluido' 
        : ((Carbon::parse($this->attributes['date_of_conclusion'])->lessThan(Carbon::now()->startOfDay())) ? 'Atrasado' 
        : 'Pendente'); 
    }
}