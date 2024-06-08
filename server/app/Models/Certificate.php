<?php

namespace App\Models;

use App\Models\Event;
use App\Models\RegistrasiEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function registrasiEvent()
    {
        return $this->belongsTo(RegistrasiEvent::class);
    }
}
