<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AppToken
 * 
 * @property int $id
 * @property string $name
 * @property int|null $app_id
 * @property string $status
 * @property array|null $properties
 * @property Carbon|null $expire_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property App|null $app
 *
 * @package App\Models
 */
class AppToken extends Model
{
	protected $table = 'app_tokens';

	protected $casts = [
		'app_id' => 'int',
		'properties' => 'json',
		'expire_at' => 'datetime'
	];

	protected $fillable = [
		'name',
		'app_id',
		'status',
		'properties',
		'expire_at'
	];

	public function app()
	{
		return $this->belongsTo(App::class);
	}
}
