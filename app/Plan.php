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
    'braintree_id', 'devices', 'hours'
  ];

  public function users()
  {
    return $this->hasMany('App\User');
  }
}
