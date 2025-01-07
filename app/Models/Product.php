<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name','code','price','stock','branch_id'];
    public function branches()
    {
        return $this->belongsTo(Branch::class);
    }
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_detail', 'product_id', 'transaction_id');
    }
}
