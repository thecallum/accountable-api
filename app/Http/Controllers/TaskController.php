<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        return [
            'tasks' => ['task one', 'task two', 'task three']
        ];
    }
}
