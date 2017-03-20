<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password', 'isAdmin', 'plan', 'api_token', 'is_first_login', 'is_subscribed', 'is_subscription_required'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token', 'api_token', 'confirmation_code', 'confirmed',
  ];

  public function plan()
  {
    return $this->belongsTo('App\Plan');
  }

  public function devices()
  {
    return $this->hasMany('App\Device');
  }

  public function visits()
  {
    return $this->hasMany('App\Visit');
  }

  public function isAdmin()
  {
    return $this->isAdmin();
  }
}
