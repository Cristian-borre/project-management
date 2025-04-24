<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status', 'priority', 'due_date', 'project_id', 'assigned_to'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class)->withDefault(); // Si no tiene proyecto, asigna un valor por defecto
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

}
