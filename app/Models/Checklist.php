<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    public $fillable = [
        'palletname',
        'ordernumber',
        'HT/nonHT',
        'date',
        'location',
        'controllername',
        'order_id'
    ];


    public function rubric(){
        return $this->hasMany(Rubric::class);
    }

    /**
     * Get the order associated with the checklist.
     */
    public function order(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Order::class);
    }
}
