<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['transaction_number','branch_id','user_id','total_price','date'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_detail', 'transaction_id', 'product_id');
    }
    public function branches()
    {
        return $this->belongsTo(Branch::class);
    }
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->transaction_number = self::generateTransactionNumber();
        });
    }

    public static function generateUniqueTransactionNumber()
    {
        do {
            $transactionNumber = self::generateTransactionNumber();
        } while (self::where('transaction_number', $transactionNumber)->exists());

        return $transactionNumber;
    }

    public static function generateTransactionNumber()
    {
        $date = now()->format('Ymd');
        $randomNumber = mt_rand(1000, 9999);
        $randomString = Str::upper(Str::random(4));
        return $date . $randomNumber . $randomString;
    }
}
