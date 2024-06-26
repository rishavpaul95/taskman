<?php

namespace App\Http\Controllers;


use App\Models\Categories;
use App\Models\Comment;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;


class TasksController extends Controller
{
    public function index()
    {

        session(['backUrl' => url()->previous()]);
        $categories = Categories::where('company_id', Auth::user()->company_id)->get();

        $selectedCategory = request('categoryFilter', 'all');

        $tasksQuery = Auth::user()->tasks();
        $currentUser = auth()->user();

        if ($selectedCategory !== 'all') {
            $tasksQuery->where('category_id', $selectedCategory);
        }

        //task based on querry // reminder! eager load comments
        $tasks = $tasksQuery->where('company_id', Auth::user()->company_id)
                ->with('comments')->get();

        $data = compact('tasks', 'categories', 'selectedCategory', 'currentUser');

        return view('tasks')->with($data);
    }


    public function store(Request $request)
    {

        if (Auth::check()) {
            $request->validate([
                'date' => 'required|date',
                'topic' => 'required|string',
                'status' => 'required|in:Completed,Active,Pending',
                'category' => 'required|exists:categories,id',
                'taskimage' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);


            $task = new Tasks;
            $task->date = $request->input('date');
            $task->topic = $request->input('topic');
            $task->status = $request->input('status');
            $task->user_id = auth()->user()->id;
            $task->category_id = $request->input('category');
            if ($request->hasFile('taskimage')) {
                $imagePath = $request->file('taskimage')->store('taskimage');
                $task->taskimage = $imagePath;
            }
            $task->assigned_by = auth()->user()->id;
            $task->company_id = auth()->user()->company_id;
            $task->save();

            return redirect('/tasks')->with('success', 'Task added successfully');
        } else {
            return redirect('/login')->with('error', 'You must be logged in to perform this action.');
        }
    }
    public function edit(Request $request, $id)
    {
        $task = Auth::user()->tasks()->find($id);
        if (!$task) {
            return redirect('/tasks')->with('error', 'Task not found');
        }

        $request->validate([
            'date' => 'required|date',
            'topic' => 'required|string',
            'status' => 'required|in:Completed,Active,Pending',
            'category' => 'required|exists:categories,id',
            'taskimage' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $task->date = $request->input('date');
        $task->topic = $request->input('topic');
        $task->status = $request->input('status');
        $task->user_id = auth()->user()->id;
        $task->category_id = $request->input('category');


        if ($request->hasFile('taskimage')) {

            if ($task->taskimage) {
                Storage::disk()->delete($task->taskimage);
            }


            $imagePath = $request->file('taskimage')->store('taskimage');
            $task->taskimage = $imagePath;
        }

        $task->save();

        return redirect('/tasks?categoryFilter=' . $task->category_id)->with('success', 'Task updated successfully');
    }

    public function delete($id)
    {
        $task = Auth::user()->tasks()->find($id);
        if ($task) {
            if ($task->taskimage) {
                Storage::disk()->delete($task->taskimage);
            }
            $task->delete();
        }
        return redirect()->back();
    }


    // Trash Section


    // public function viewtrash()
    // {
    //     $tasks = Auth::user()->tasks()->onlyTrashed()->get();
    //     $data = compact('tasks');
    //     return view('task_trash')->with($data);
    // }
    //
    //
    // public function restore($id)
    // {
    //     $task = Auth::user()->tasks()->withTrashed()->find($id);
    //     if ($task) {
    //         $task->restore();
    //     }
    //     return redirect('/tasks/trash');
    // }

    // public function forceddelete($id)
    // {
    //     $task = Auth::user()->tasks()->withTrashed()->find($id);
    //     if ($task) {
    //         $task->forceDelete();
    //     }
    //     return redirect('/tasks/trash');
    // }
}
