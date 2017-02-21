<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
	use Notifiable;

	protected $table = 'user';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'openid',
		'username',
		'email',
		'email_status',
		'password',
		'permission_string',
		'certificate_as',
		'information_id',
		'credits'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function bookRequests(){
		return $this->hasMany('App\Models\BookRequest', 'user_id', 'id');
	}
}
