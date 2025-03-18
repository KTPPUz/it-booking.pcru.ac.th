<?php

namespace App\Models;

use App\Models\Base\User as BaseUser;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends BaseUser implements AuthenticatableContract
{
    use Authenticatable;

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'emp_code',
		'prefix',
		'position',
		'name',
		'mobile_number',
		'internal_number',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'department',
		'sect'
	];
}
