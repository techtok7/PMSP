<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'availability_batch_id',
        'user_id',
        'date',
        'start_time',
        'end_time',
        'day',
        'is_occupied',
    ];

    protected $casts = [
        'is_occupied' => 'boolean',
    ];

    public function availabilityBatch()
    {
        return $this->belongsTo(AvailabilityBatch::class);
    }
}
