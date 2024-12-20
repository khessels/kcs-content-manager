<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AppKvStore
 * 
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $app_id
 * @property string $topic
 * @property string $key
 * @property string|null $value
 * @property array|null $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property App|null $app
 * @property AppKvStore|null $app_kv_store
 * @property Collection|AppKvStore[] $app_kv_stores
 *
 * @package App\Models
 */
class AppKvStore extends Model
{
	protected $table = 'app_kv_store';

	protected $casts = [
		'parent_id' => 'int',
		'app_id' => 'int',
		'data' => 'json'
	];

	protected $fillable = [
		'parent_id',
		'app_id',
		'topic',
		'key',
		'value',
		'data'
	];

	public function app()
	{
		return $this->belongsTo(App::class);
	}

	public function app_kv_store()
	{
		return $this->belongsTo(AppKvStore::class, 'parent_id');
	}

	public function app_kv_stores()
	{
		return $this->hasMany(AppKvStore::class, 'parent_id');
	}
}
