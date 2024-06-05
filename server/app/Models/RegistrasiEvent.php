<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegistrasiEvent extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
