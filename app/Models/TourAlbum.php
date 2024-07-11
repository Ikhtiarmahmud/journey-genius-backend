<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
        'user_id',
        'start_date',
        'end_date',
        'ratings',
        'location',
        'remarks'
    ];
}
