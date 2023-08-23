<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseProduct extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function getUserAttribute()
    {
        $user = User::find($this->purchase->user_id);
        return collect($user);
    }
}
