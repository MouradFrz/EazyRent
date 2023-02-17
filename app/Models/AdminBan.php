<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminBan extends Model
{
    use HasFactory;
    protected $table = 'adminbans';
    protected $primaryKey='banID';
}
