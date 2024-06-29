<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyTour extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'location',
        'charge',
        'max_people',
        'duration',
        'status',
        'description',
        'included',
        'excluded',
        'highlights',
        'start_date',
        'end_date',
        'thumbnail',
    ];
}
