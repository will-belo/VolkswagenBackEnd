<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = 'trainings';

    protected $fillable = [
        'name',
        'live_url',
        'material',
        'active',
        'certify',
        'date',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'concessionaire_training_user', 'trainings_id', 'common_user_id');
    }
}
