<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Designation
 * @package App\Models
 */
class Designation extends Model
{
    use SoftDeletes;
    protected $table = 'designation';
}
