<?php

namespace App\Models;

use App\Priority;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'priority', 'control_at', 'is_comleted'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'priority' => Priority::class,
        'control_at' => 'date',
    ];

    public function isControl(): Attribute
    {
        return Attribute::get(function () {
            return isset($this->control_at);
        });
    }

    public function remainingDaysControl(): Attribute
    {
        return Attribute::get(function () {
            if (isset($this->control_at)) {
                return today()->diffInDays($this->control_at);
            }
        });
    }
}
