<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * 
 * @property int $id
 * @property int|null $parent_id
 * @property string $app
 * @property int|null $user_id
 * @property string $status
 * @property string $page
 * @property string|null $template
 * @property array|null $properties
 * @property string|null $roles
 * @property string $env
 * @property string $env_source
 * @property Carbon|null $publish_at
 * @property Carbon|null $expire_at
 * @property Carbon|null $last_seen_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Content|null $content
 * @property User|null $user
 *
 * @package App\Models
 */
class Page extends Model
{
	protected $table = 'pages';

	protected $casts = [
		'parent_id' => 'int',
		'user_id' => 'int',
		'properties' => 'json',
		'publish_at' => 'datetime',
		'expire_at' => 'datetime',
		'last_seen_at' => 'datetime'
	];

	protected $fillable = [
		'parent_id',
		'app',
		'user_id',
		'status',
		'page',
		'template',
		'properties',
		'roles',
		'env',
		'env_source',
		'publish_at',
		'expire_at',
		'last_seen_at'
	];

	public function content()
	{
		return $this->belongsTo(Content::class, 'parent_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
