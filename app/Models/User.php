<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'first_name',
            'last_name',
            'email',
            'roles',
            'status',
            'country_id',
            'password',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden
        = [
            'password',
            'remember_token',
        ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts
        = [
            'email_verified_at' => 'datetime',
        ];


    /**
     * Get user full name
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name) . ' ' . trim($this->last_name);
    }

    /**
     * Check user roles
     *
     * @param string $p_role - the role name as in DB 'reader', 'author', 'reviewer'....
     * @return bool
     */
    public function checkRole(string $p_role): bool
    {
        return in_array($p_role, explode(',', $this->roles));
    }

    /**
     * Check if user has role of 'usual'
     *
     * @return bool
     */
    public function isUsual(): bool
    {
        return $this->checkRole('usual');
    }

    /**
     * Check if user has role of 'admin'
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->checkRole('admin');
    }

    /**
     * Check if user has role of 'moderator'
     *
     * @return bool
     */
    public function isModerator(): bool
    {
        return $this->checkRole('moderator');
    }

    /**
     * Get the country record associated with the user.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    /**
     * Get the country record associated with the user.
     */
    public function hasRole($role)
    {
        return in_array($role, $roles = $this->getRoles());
    }

    /**
     * Get the country record associated with the user.
     */
    public function getRoles()
    {
        $roles = explode(',', $this->roles);
        foreach ($roles as $k => $role) {
            $roles[$role] = $role;
            unset($roles[$k]);
        }

        return $roles;
    }

    /**
     * Get the country record associated with the user.
     */
    public function addRole($role)
    {
        $roles = $this->getRoles();
        $roles[] = $role;
        $roles = array_unique($roles);
        $roles = implode(',', $roles);
        $this->roles = $roles;
        $this->save();

        return;
    }

    /**
     * Get the country record associated with the user.
     */
    public function removeRole($role)
    {
        $roles = $this->getRoles();
        unset($roles[$role]);
        $roles = array_unique($roles);
        $roles = implode(',', $roles);
        $this->roles = $roles;
        $this->save();

        return;
    }
}
