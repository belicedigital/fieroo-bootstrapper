<?php

namespace Fieroo\Bootstrapper\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Fieroo\Exhibitors\Models\Exhibitor;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function exhibitor()
    {
        return $this->hasOne(Exhibitor::class);
    }

    public function getRedirectRoute()
    {
        if(Auth::user()->roles->first()->name == 'espositore') {
            dd(Auth::user()->exhibitor->detail);
            $user = User::findOrFail(Auth::user()->id);
            if(is_null($user->exhibitor->detail)) {
                return redirect()->route('compile-data-after-login');
            }
        }
    }
}
