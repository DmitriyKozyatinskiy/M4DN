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
    'name', 'email', 'password', 'isAdmin', 'plan',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public function plan()
  {
    return $this->belongsTo('App\Plan');
  }

  public function devices()
  {
    return $this->hasMany('App\Device');
  }

  public function isAdmin()
  {
    return $this->isAdmin();
  }
}