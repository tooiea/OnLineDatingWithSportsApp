<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $content
 */
class OpenApiSpec extends Model
{
    protected $table = 'openapi_specs';
    protected $fillable = ['name', 'description', 'content'];
}
