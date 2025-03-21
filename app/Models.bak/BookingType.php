<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingType extends Model
{
    use HasFactory;

    protected $table = 'booking_type';

    protected $primaryKey = 'type_id';

    protected $fillable = [
        'name',
        'status',
    ];


}