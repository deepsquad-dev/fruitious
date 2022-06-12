<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etag extends Model
{
    use HasFactory;

    protected $table = 'etag';

    public $incrementing = false;

    protected $fillable = ['etag'];



}
