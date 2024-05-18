<?php

namespace App\Domain\Pizza\Models;

use App\Domain\Pizza\ModelStates\PizzaState;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

class Pizza extends Model
{
    use HasFactory;
    use HasStates;

    /**
     * @return array{status: 'App\Domain\Pizza\ModelStates\PizzaState'}
     */
    protected function casts(): array
    {
        return [
            'status' => PizzaState::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
