<?php namespace Worktrial\Http\Controllers;
use Worktrial\User;
use Worktrial\Task;
use Auth;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

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
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index($sort='created_at')
	{
        $tasks = Task::where('owner', Auth::user()->id)
                    ->orWhere('performer', Auth::user()->id)
                    ->with('owner')->with('performer')
                    ->orderBy($sort)
                    ->get();

		return view('home', ['tasks' => $tasks, 'users' => User::all()]);
	}

}
