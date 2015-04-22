<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Worktrial\User;
use Worktrial\Task;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UserTableSeeder');
        $this->call('TaskTableSeeder');
	}

}

class UserTableSeeder extends Seeder {

    public function run() {
        DB::table("users")->delete();

        // TODO:: use Registrar->create instead

        User::create(['email' => 'test@test.com', 'password'=> bcrypt('test'), 'name'=> 'test']);

        User::create(['email' => 'test2@test.com', 'password'=> bcrypt('test'), 'name'=> 'test second']);
    }
}

class TaskTableSeeder extends Seeder {

    public function run() {
        DB::table("tasks")->delete();

        $existingUser = User::first();

        for($i = 0; $i < 5; $i++) {
            Task::create(['description' => 'test description' . $i, 'owner'=> $existingUser->id, 'performer'=> $existingUser->id, 'state' => intval($i%3)]);
            Task::create(['description' => 'test description' . $i, 'owner'=> $existingUser->id, 'performer'=> null, 'state' => intval($i%2)]);
        }

    }
}