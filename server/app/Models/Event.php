<?php

namespace App\Models;

use App\Models\User;
use App\Models\Feedback;
use App\Models\Narasumber;
use App\Models\Certificate;
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

    public function nid1()
    {
        return $this->belongsTo(Narasumber::class, 'nid_1');
    }
    public function nid2()
    {
        return $this->belongsTo(Narasumber::class, 'nid_2');
    }
    public function nid3()
    {
        return $this->belongsTo(Narasumber::class, 'nid_3');
    }
    public function nid4()
    {
        return $this->belongsTo(Narasumber::class, 'nid_4');
    }
    public function nid5()
    {
        return $this->belongsTo(Narasumber::class, 'nid_5');
    }
    public function nid6()
    {
        return $this->belongsTo(Narasumber::class, 'nid_6');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
