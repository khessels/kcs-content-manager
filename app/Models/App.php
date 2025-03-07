<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

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
    use HasApiTokens;

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
    public function users()
    {
        return $this->hasMany(AppUser::class);
    }
	public function config()
	{
		return $this->hasMany(AppKvStore::class)->where('topic', 'config');
	}

}
