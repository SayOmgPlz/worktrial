<?php namespace Worktrial\Console\Commands;

use Illuminate\Console\Command;
use Worktrial\Refresh;
use Worktrial\SocketUser;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class Serve extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'worktrial:refresh';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

    protected $refresh;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Refresh $refresh)
	{
        parent::__construct();
        $this->refresh = $refresh;

        $this->refresh->getEmitter()->on("open", function(SocketUser $user)
        {
            $this->line("<info>" . $user->getId() . " connected.</info>");
        });

        $this->refresh->getEmitter()->on("close", function(SocketUser $user)
        {
            $this->line("<info>" . $user->getId() . " disconnected.</info>");
        });

        $this->refresh->getEmitter()->on("message", function(SocketUser $user, $message)
        {
            $this->line("<info>New message from " . $user->getId() . ":</info> <comment>" . $message . "</comment><info>.</info>");
        });

        $this->refresh->getEmitter()->on("name", function(SocketUser $user, $message)
        {
            $this->line("<info>User changed their name to:</info> <comment>" . $message . "</comment><info>.</info>");
        });

        $this->refresh->getEmitter()->on("error", function(SocketUser $user, $exception)
        {
            $this->line("<info>User encountered an exception:</info> <comment>" . $exception->getMessage() . "</comment><info>.</info>");
        });

    }
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $port = (integer) $this->option("port");
        if (!$port)
        {
            $port = 7778;
        }

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    $this->refresh
                )
            ),
            $port
        );

        $this->line("<info>Listening on port</info> <comment>" . $port . "</comment><info>.</info>");
        $server->run();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */


	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
        return [
            ["port", null, InputOption::VALUE_REQUIRED, "Port to listen on.", null]
        ];
	}

}
