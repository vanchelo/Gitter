<?php namespace Laravelrus\Gitter;

use Illuminate\Database\Eloquent\Model;

class GitterUser extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = array(
        'id', 'username', 'displayName', 'avatarUrlSmall', 'avatarUrlMedium', 'url'
    );
}
