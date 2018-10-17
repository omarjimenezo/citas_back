<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 17 Oct 2018 01:09:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 * 
 * @property int $id
 * @property int $id_status
 * @property string $email
 * @property string $password
 * @property string $token
 * @property int $id_user_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\UserDatum $user_datum
 *
 * @package App\Models
 */
class User extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'user';

	protected $casts = [
		'id_status' => 'int',
		'id_user_type' => 'int'
	];

	protected $hidden = [
		'password',
		'token'
	];

	protected $fillable = [
		'id_status',
		'email',
		'password',
		'token',
		'id_user_type'
	];

	public function user_datum()
	{
		return $this->hasOne(\App\Models\UserDatum::class, 'id_user');
	}
}
