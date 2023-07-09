<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggested extends Model
{
    use HasFactory;
    protected $fillable = [
        'suggestion_id',
        'product_id'
    ];
}
