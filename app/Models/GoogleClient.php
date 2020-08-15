<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleClient extends Model{

    protected $table = 'google_client';

    protected $casts = [
        'user_id' => 'integer',
        'access_token' => 'string',
        'expires_in' => 'integer',
        'refresh_token' => 'string',
        'created' => 'integer'
    ];

    protected $fillable = [
        'user_id',
        'access_token',
        'expires_in',
        'refresh_token',
        'created'
    ];

}

?>
