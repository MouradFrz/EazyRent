<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $table = 'vehicules';
    protected $primaryKey = 'plateNb';
    public $timestamps = false;
}
