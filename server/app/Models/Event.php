<?php

namespace App\Models;

use App\Models\User;
use App\Models\Feedback;
use App\Models\Narasumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function narasumber()
    {
        return $this->belongsTo(Narasumber::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
