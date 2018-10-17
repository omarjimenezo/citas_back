<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 17 Oct 2018 01:09:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UserDatum
 * 
 * @property int $id_user
 * @property string $address
 * @property int $phone
 * @property int $age
 * @property string $gender
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class UserDatum extends Eloquent
{
	protected $primaryKey = 'id_user';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_user' => 'int',
		'phone' => 'int',
		'age' => 'int'
	];

	protected $fillable = [
		'address',
		'phone',
		'age',
		'gender'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'id_user');
	}
}
