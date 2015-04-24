<?php namespace Worktrial;

use Evenement\EventEmitterInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class SocketUser  {

    protected $socket;
    protected $id;

    public function __construct()
    {
        $this->id   = 0;
    }

    public function getSocket()
    {
        return $this->socket;
    }

    public function setSocket(ConnectionInterface $socket)
    {
        $this->socket = $socket;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}
