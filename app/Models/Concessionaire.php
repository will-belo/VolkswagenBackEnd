<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concessionaire extends Model
{
    use HasFactory;

    protected $table = 'concessionaire';

    public function address()
    {
        return $this->belongsTo(Address::class, 'concessionaire_address');
    }
}
