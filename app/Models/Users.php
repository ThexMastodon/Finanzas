<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = [
        'username',
         'name',
         'last_name',
         'second_last_name',
         'email',
         'password',
         'active',
         'image',
    ];

    public function cancelados()
    {
        return $this->hasMany(Cancelado::class, 'id', 'users_id');
    }
}
