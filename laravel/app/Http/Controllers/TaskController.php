<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Task;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get(['id', 'completed', 'title'])->toArray();
        return view('home', compact('tasks'));
    }

    public function create (Request $request) {
      $task = new Task;
      $task->user_id = Auth::id();
      $task->title = $request->title;
      $task->completed = 0;
      $task->save();

      return redirect('/tasks');
    }

    public function completed ($id) {
      $task = Task::find($id);
      $task->completed = 1;
      $task->save();

      return redirect('/tasks');
    }

    public function delete ($id) {
      $task = Task::find($id);
      $task->delete();

      return redirect('/tasks');
    }
}
