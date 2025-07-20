<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
   
    protected $fillable = [
    'name', 'email', 'password', 'role',
    'jabatan', 'no_telp', 'job', 'lokasi',
    'client_id'
    ];

    public function client()
{
    return $this->belongsTo(Client::class, 'client_id');
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];


}
