<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mimetype
 * 
 * @property int $id
 * @property string $mimetype
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Mimetype extends Model
{
	protected $table = 'mimetypes';

	protected $fillable = [
		'mimetype'
	];
}
