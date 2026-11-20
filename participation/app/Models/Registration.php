<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['user_id', 'event_id', 'datetime'])]
class Registration extends Model
{
    /** @use HasFactory<\Database\Factories\RegistrationFactory> */
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function priceCount(): int
    {
        $event = $this->event;
        $normal = now() > $event->early_bird_until;

        $price = $event->early_bird_price;
        if ($normal) {
            $price *= $event->price_multiplier;
        }
        return (int)$price;
    }
}
