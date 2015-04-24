<?php
use Worktrial\User;
use Worktrial\Task;



class TaskCrudTest extends TestCase {

    public function test_fields_updated()
    {

        $existingUser = User::first();

        $task = Task::create(['description' => '', 'owner'=> $existingUser->id, 'performer'=> null, 'state' => 0]);

        $newDetails = ['performer' => $existingUser->id,'description' => 'test', 'state' => 1 ];

        $this->call('PUT', 'tasks/' . $task->id, $newDetails);

        $updatedTask = Task::find($task->id);

        $this->assertTrue(array_intersect($newDetails, $updatedTask->toArray()) == $newDetails);

    }

    public function test_fields_create()
    {
        // set up Auth::user
        $this->be(User::first());

        $existingUser = User::first();

        $newDetails = ['performer' => $existingUser->id,'description' => 'test', 'state' => 1 ];

        $response = $this->call('POST', 'tasks', $newDetails);

        $newTask = json_decode($response->getContent())->data;

        $task = Task::find($newTask->id);

        $this->assertTrue($task !== null);

    }

    public function test_fields_delete()
    {
        $task = Task::first();

        $response = $this->call('DELETE', 'tasks/' . $task->id);

        $task = Task::find( $task->id);

        $this->assertTrue($task === null);

    }

    public function test_fields_get()
    {
        $task = Task::first();

        $taskData = (array)json_decode($this->call('GET', 'tasks/' . $task->id)->getContent())->data;

        $this->assertTrue(array_intersect($taskData, $task->toArray()) == $taskData);

    }


}
