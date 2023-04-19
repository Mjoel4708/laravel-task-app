<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'due_date',
        'start_date',
        'end_date',
        'remarks',
        'status_id',

    ];

    protected $hidden = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user for the task.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the task for the user.
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Tasks::class);
    }

    /**
     * Get the status for the task.
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Task_status::class);
    }


}