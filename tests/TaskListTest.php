<?php
use Worktrial\User;
use Worktrial\Task;



class TaskListTest extends TestCase {

    public function test_relatedTasks_is_different_after_deletion_of_task()
    {
        $user = User::first();

        $beforeDelete = count($user->relatedTasks()->get());

        $user->relatedTasks()->first()->delete();

        $this->assertTrue($beforeDelete > count($user->relatedTasks()->get()));
    }

    public function test_mytasks_returns_all_user_tasks() {
        $user = User::first();

        $this->be($user);

        $response = $this->call('GET', 'tasks/mytasks/owner?order=1');

        $responseTasks = json_decode($response->getContent())->data->tasks;

        $this->assertEquals(count($responseTasks), count($user->relatedTasks()->get()));

    }

    public function test_deleting_user_unassignes_owner() {
        $user = User::first();

        $taskIds = $user->relatedTasks()->get()->lists('id');

        $user->delete();

        $tasksOwner = Task::find($taskIds)->lists('owner');

        // check if all values in the array are null
        $tasksWithOwner = array_filter($tasksOwner,function($el){
            return $el !== null;
        });

        $this->assertTrue(empty($tasksWithOwner));

    }

}
