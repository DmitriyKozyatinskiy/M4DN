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

    /**
     * The users that belong to the patrol.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
