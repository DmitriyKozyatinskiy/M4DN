<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title', 'url'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function device()
  {
    return $this->belongsTo('App\Device');
  }

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = [
    'created_at', 'updated_at',
  ];
}
