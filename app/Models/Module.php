<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    public function project()
    {
        return $this->hasOne(Project::class,'id','project_id');
    }
    public function parent()
    {
        return $this->belongsTo(Module::class,'parent_id');
    }
}
