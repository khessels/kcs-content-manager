<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AppUser
 * 
 * @property int $id
 * @property string $name
 * @property int|null $user_id
 * @property string $status
 * @property array|null $properties
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class AppUser extends Model
{
	protected $table = 'app_users';

	protected $casts = [
		'user_id' => 'int',
		'properties' => 'json'
	];

	protected $fillable = [
		'name',
		'user_id',
		'status',
		'properties'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
