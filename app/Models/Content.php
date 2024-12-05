<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Content
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $user_id
 * @property string $status
 * @property string|null $page
 * @property string|null $language
 * @property string $key
 * @property string|null $value
 * @property array|null $data
 * @property string $mimetype
 * @property Carbon|null $publish_at
 * @property Carbon|null $expire_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Content|null $content
 * @property User|null $user
 * @property Collection|Content[] $contents
 *
 * @package App\Models
 */
class Content extends Model
{
	protected $table = 'content';

	protected $casts = [
		'parent_id' => 'int',
		'user_id' => 'int',
		'data' => 'json',
		'publish_at' => 'datetime',
		'expire_at' => 'datetime'
	];

	protected $fillable = [
		'parent_id',
		'user_id',
        'app',
		'status',
		'page',
		'language',
		'key',
		'value',
		'data',
		'mimetype',
		'publish_at',
		'expire_at'
	];

	public function content()
	{
		return $this->belongsTo(Content::class, 'parent_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function contents()
	{
		return $this->hasMany(Content::class, 'parent_id');
	}
}
