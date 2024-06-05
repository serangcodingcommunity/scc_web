<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Like;
use App\Models\Post;
use App\Models\Event;
use App\Models\Member;
use App\Models\Sosmed;
use App\Models\Comment;
use App\Models\Partner;
use App\Models\Feedback;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Portofolio;
use App\Models\RegistrasiEvent;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function ($pr) {
            return [$pr['name'] => true];
        });
    }

    public function pendidikans()
    {
        return $this->hasMany(Pendidikan::class);
    }

    public function pekerjaans()
    {
        return $this->hasMany(Pekerjaan::class);
    }

    public function sosmeds()
    {
        return $this->hasMany(Sosmed::class);
    }

    public function portofolios()
    {
        return $this->hasMany(Portofolio::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function registrasiEvents()
    {
        return $this->hasMany(RegistrasiEvent::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function partner()
    {
        return $this->hasOne(Partner::class);
    }
}
