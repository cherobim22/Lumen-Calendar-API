<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleClient extends Model{


    protected $table = 'google_client';

    protected $casts = [
        'blog_id' => 'integer',
        'access_token' => 'string',
        'expires_in' => 'integer',
        'refresh_token' => 'string',
        'created' => 'integer'
    ];

    //atributo fillable
    protected $fillable = [
        'blog_id',
        'access_token',
        'expires_in',
        'refresh_token',
        'created'
    ];

    //atributo casts convertendo date para timestamp
}

?>
