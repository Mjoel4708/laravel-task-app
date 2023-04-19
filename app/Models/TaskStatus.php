<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Tasks::class);
    }
}