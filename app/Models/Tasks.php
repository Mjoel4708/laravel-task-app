<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status_id',
    ];

    protected $hidden = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the status for the task.
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Task_status::class);
    }

    /**
     * Get the tasks for the user.
     * @return HasMany
     */
    public function user_tasks(): HasMany
    {
        return $this->hasMany(User_tasks::class);
    }

}
