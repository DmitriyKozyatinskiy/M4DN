<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'level', 'description', 'devices', 'days', 'price', 'saveIncognito', 'saveAllHistory',
  ];

  public function users()
  {
    return $this->hasMany('App\User');
  }
}
