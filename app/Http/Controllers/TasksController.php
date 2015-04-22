<?php namespace Worktrial\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Worktrial\Http\Controllers\Controller;
use Worktrial\User;
use Worktrial\Task;
use Auth;

class TasksController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

	}

    public function getMytasks($sortBy="created_at") {

        if(!Request::ajax()) {
            // TODO::return page not found view;
            return;
        }

        $tasks = Task::where('owner', Auth::user()->id)
            ->orWhere('performer', Auth::user()->id)
            ->with('owner')->with('performer')
            ->orderBy($sortBy)->get();

        return json_encode(['data' => view('tasks.tasks-list', ['tasks' => $tasks])->render(), 'errors' => false]);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
