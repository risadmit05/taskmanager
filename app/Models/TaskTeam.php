<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTeam extends Model
{
    use HasFactory;

    public function project()
    {
        return $this->belongsToMany(Project::class);
    }
    public function task()
    {
        return $this->belongsToMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
