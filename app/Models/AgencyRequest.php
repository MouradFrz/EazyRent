<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyRequest extends Model
{
    use HasFactory;
    protected $table='agencyrequests';
    public $timestamps = false;
}
