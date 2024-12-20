<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class App
 * 
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $status
 * @property array|null $properties
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|AppKvStore[] $app_kv_stores
 * @property Collection|AppToken[] $app_tokens
 *
 * @package App\Models
 */
class App extends Model
{
	protected $table = 'apps';

	protected $casts = [
		'user_id' => 'int',
		'properties' => 'json'
	];

	protected $fillable = [
		'user_id',
		'name',
		'status',
		'properties'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function app_kv_stores()
	{
		return $this->hasMany(AppKvStore::class);
	}

	public function app_tokens()
	{
		return $this->hasMany(AppToken::class);
	}
}
