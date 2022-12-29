<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // protected $table = 'tasks';
    protected $fillable = [
       'name',
       'tasklist',
       'desc',
       'startDate',
       'dueDate',
       'priority',
       'client',
       'vendor',
       'assignTo',
       'forwardedTo',
       'addedBy',
       'project',
       'status',
       'images',
       'deleted_at',
    ];
}
