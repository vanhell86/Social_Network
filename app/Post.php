<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed user_id
 */
class Post extends Model
{
    protected $fillable = ['user_id','title', 'content'];
}