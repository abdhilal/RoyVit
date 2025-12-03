<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeProduct extends Model
{
    /** @use HasFactory<\Database\Factories\TreeProductFactory> */
    use HasFactory;

    protected $fillable = [
        'factory',
        'name',
        'quantity',
        'Regular_price',
        'General_price',
        'wholesale_price',
        'Bonus1',
        'Bonus2',
        'warehouse_id',
        'month',
        'year',
        'month_year',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
