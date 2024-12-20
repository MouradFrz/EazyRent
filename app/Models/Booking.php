<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $primaryKey = 'bookingID';
    protected $fillable = ['secretaryRatesClient','state','failedDate','failedSeen','complaintID'];
}
