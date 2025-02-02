<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'module_id',
        'sub_module_id',
        'sub_sub_module_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
    ];



    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    public function teamTasks()
    {
        return $this->hasMany(TaskTeam::class, 'task_id');
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'to_do':
                return 'primary';
            case 'in_progress':
                return 'warning';
            case 'completed':
                return 'success';
            default:
                return 'secondary';
        }
    }

    public function checklistItems()
    {
        return $this->hasMany(ChecklistItem::class);
    }
}
