<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'group_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function pettyCashes() {
        return $this -> belongsToMany(PettyCash::class, 'petty_cash_products', 'petty_cash_id', 'product_id')->withPivot('amount_request', 'number_invoice', 'name_product', 'supplier', 'cost_object', 'costDetails', 'costFinal')->withTimestamps();
    }
}
