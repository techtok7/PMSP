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
        'slots',
    ];

    protected $casts = [
        'is_occupied' => 'boolean',
    ];

    protected function getStartTimeAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

    protected function getEndTimeAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

    public function availabilityBatch()
    {
        return $this->belongsTo(AvailabilityBatch::class);
    }

    static function getAvailableSlots($availability)
    {
        $slots = [];

        $start_time = strtotime($availability->start_time);
        $end_time = strtotime($availability->end_time);

        $val = 0;

        while ($start_time < $end_time) {
            $val += 30;
            $slots[] = $val;
            $start_time += 30 * 60;
        }

        $slots = '-' . implode('-', $slots) . '-';

        return $slots;
    }
}
