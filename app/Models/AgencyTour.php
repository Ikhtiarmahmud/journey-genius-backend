<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyTour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'duration',
        'person',
        'description',
        'included',
        'excluded',
        'highlights',
    ];
}
