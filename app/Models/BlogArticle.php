<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlogArticle
 * 
 * @property int $id
 * @property int|null $blogs_id
 * @property string $status
 * @property string|null $content
 * @property array|null $properties
 * @property string|null $roles
 * @property int|null $sort_order
 * @property Carbon|null $publish_at
 * @property Carbon|null $expire_at
 * @property Carbon|null $last_seen_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Blog|null $blog
 *
 * @package App\Models
 */
class BlogArticle extends Model
{
	protected $table = 'blog_articles';

	protected $casts = [
		'blogs_id' => 'int',
		'properties' => 'json',
		'sort_order' => 'int',
		'publish_at' => 'datetime',
		'expire_at' => 'datetime',
		'last_seen_at' => 'datetime'
	];

	protected $fillable = [
		'blogs_id',
		'status',
		'content',
		'properties',
		'roles',
		'sort_order',
		'publish_at',
		'expire_at',
		'last_seen_at'
	];

	public function blog()
	{
		return $this->belongsTo(Blog::class, 'blogs_id');
	}
}
