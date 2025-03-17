<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * 
 * @property int $id
 * @property int|null $pages_id
 * @property string $status
 * @property string|null $template
 * @property string|null $name
 * @property array|null $properties
 * @property string|null $roles
 * @property Carbon|null $publish_at
 * @property Carbon|null $expire_at
 * @property Carbon|null $last_seen_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Page|null $page
 * @property Collection|BlogArticle[] $blog_articles
 *
 * @package App\Models
 */
class Blog extends Model
{
	protected $table = 'blogs';

	protected $casts = [
		'pages_id' => 'int',
		'properties' => 'json',
		'publish_at' => 'datetime',
		'expire_at' => 'datetime',
		'last_seen_at' => 'datetime'
	];

	protected $fillable = [
		'pages_id',
		'status',
		'template',
		'name',
		'properties',
		'roles',
		'publish_at',
		'expire_at',
		'last_seen_at'
	];

	public function page()
	{
		return $this->belongsTo(Page::class, 'pages_id');
	}

	public function blog_articles()
	{
		return $this->hasMany(BlogArticle::class, 'blogs_id');
	}
}
