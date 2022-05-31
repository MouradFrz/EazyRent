<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickUpLocation extends Model
{
    use HasFactory;
    protected $table = 'pickuplocations';
    protected $primaryKey = 'id';
    protected $fillable= ['brancheId', 'address_address', 'address_latitude','address_longitude'];
}
