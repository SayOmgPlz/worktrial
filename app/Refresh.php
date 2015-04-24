<?php namespace Worktrial;

use Evenement\EventEmitterInterface;
use Evenement\EventEmitter;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Exception;
use SplObjectStorage;
use Auth;
use Log;
use Worktrial\Task;
use Worktrial\User;
use Worktrial\SocketUser;

class Refresh implements MessageComponentInterface {

    protected $users;
    protected $emitter;

    public function getUserBySocket(ConnectionInterface $socket)
    {
        foreach ($this->users as $next)
        {
            if ($next->getSocket() === $socket)
            {
                return $next;
            }
        }
        return null;
    }

    public function getEmitter()
    {
        return $this->emitter;
    }

    public function setEmitter(EventEmitterInterface $emitter)
    {
        $this->emitter = $emitter;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function __construct(EventEmitterInterface $emitter)
    {
        $this->emitter = $emitter;
        $this->users   = new SplObjectStorage();

    }

    public function onOpen(ConnectionInterface $socket)
    {
        $this->emitter->emit("open", []);
    }

    public function onMessage(ConnectionInterface $socket, $message)
    {
        $message = json_decode($message);

        if(isset($message->user)) {
            $user = new SocketUser();
            $user->setSocket($socket);
            $user->setId(intval($message->user));
            $this->users->attach($user);
        }

        if(isset($message->users)) {
            $user    = $this->getUserBySocket($socket);

            //$task = Task::find($message->task);

            foreach ($this->users as $next)
            {
                 if (  in_array($next->getId(),$message->users) )
                 {
                    $next->getSocket()->send(json_encode([
                        "user" => [
                            "id"   => $user->getId()
                        ],
                        "message" => json_encode($message)
                    ]));
                 }

            }
        }
    }

    public function onClose(ConnectionInterface $socket)
    {
        $user = $this->getUserBySocket($socket);

        if ($user)
        {
            $this->users->detach($user);
            $this->emitter->emit("close", [$user]);
        }
    }

    public function onError(ConnectionInterface $socket, Exception $exception)
    {
        $user = $this->getUserBySocket($socket);
        if ($user)
        {
            $user->getSocket()->close();
            $this->emitter->emit("error", [$user, $exception]);
        }
    }

}
