<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'budget',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function todoTasks()
    {
        return $this->hasMany(Task::class)->where('status','=','to_do');
    }
    public function inprogressTasks()
    {
        return $this->hasMany(Task::class)->where('status','=','in_progress');
    }

    public function completedTasks()
    {
        return $this->hasMany(Task::class)->where('status','=','completed');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function getStatusAttribute()
    {
        $today = Carbon::now();

        if ($this->start_date && $today->lt($this->start_date)) {
            return 'pending';
        }

        if ($this->end_date && $this->end_date->lt($today)) {
            $unfinishedTasks = $this->tasks()->where('status', '!=', 'completed')->count();
            return $unfinishedTasks > 0 ? 'unfinished' : 'finished';
        }

        return 'on_going';
    }

    public function teamProjects()
    {
        return $this->belongsToMany(ProjectTeam::class, 'project_teams', 'project_id', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_teams', 'project_id', 'user_id');
    }
}
