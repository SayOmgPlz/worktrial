<?php
use Worktrial\User;


class TaskListTest extends TestCase {

    public function test_relatedTasks_is_different_after_deletion_of_task()
    {
        $user = User::first();

        $beforeDelete = count($user->relatedTasks()->get());

        $user->relatedTasks()->first()->delete();

        $this->assertTrue($beforeDelete > count($user->relatedTasks()->get()));
    }

    public function test_mytasks_rout() {
        //$user = User::first();

        //Auth::loginUsingId($user->id);


       // $response = $this->call('GET', 'tasks/mytasks', [], [], [ 'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest' ]);

    }

}
