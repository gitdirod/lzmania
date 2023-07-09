<?php

namespace App\Models;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'envoice',
        'people',
        'ccruc',
        'city',
        'address',
        'phone_id'
    ];

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }
}
