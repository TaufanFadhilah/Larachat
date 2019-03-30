<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['user_id', 'receiver_id', 'message'];

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function Receiver()
    {
        return $this->belongsTo('App\User');
    }
}
