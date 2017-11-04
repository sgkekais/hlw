<?php

namespace HLW;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * HLW\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\User whereUpdatedAt($value)
 */

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
