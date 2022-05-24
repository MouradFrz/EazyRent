<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyBan extends Model
{
    use HasFactory;
    public $table = "agencybans";
    public $timestamps = false;
}
