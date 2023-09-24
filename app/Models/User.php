<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nip',
        'email',
        'password',
        'foto_profile',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userHasLevel()
    {
        return $this->hasOne(UserHasLevel::class, 'user_id', 'id')
            ->whereHas('historiAmi', function ($query) {
                $query->whereStatus(HistoriAmi::ACTIVE);
            });
    }

    public function userHasLevelNotActive()
    {
        return $this->hasOne(UserHasLevel::class, 'user_id', 'id');
    }

    public function kepalaP4mp()
    {
        return $this->hasOne(KepalaP4mp::class,  'user_id', 'id');
    }

    public function akunJurusan()
    {
        return $this->hasOne(AkunJurusan::class,  'user_id', 'id');
    }

    public function akunAuditor()
    {
        return $this->hasOne(AkunAuditor::class,  'user_id', 'id');
    }

    public function akunAuditee()
    {
        return $this->hasOne(AkunAuditee::class,  'user_id', 'id');
    }
}
