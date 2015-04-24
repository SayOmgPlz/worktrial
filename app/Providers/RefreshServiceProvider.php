<?php namespace Worktrial\Providers;

use Evenement\EventEmitter;
use Illuminate\Support\ServiceProvider;
use Ratchet\Server\IoServer;

class RefreshServiceProvider extends ServiceProvider {

    protected $defer = true;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
    public function register()
    {

        $this->app->bind("refresh.emitter", function()
        {
            return new EventEmitter();
        });

        $this->app->bind("refresh.refresh", function()
        {
            return new Refresh(
                $this->app->make("refresh.emitter")
            );
        });

        $this->app->bind("refresh.user", function()
        {
            return new SocketUser();
        });

        $this->app->bind("refresh.command.serve", function()
        {
            return new Worktrial\Console\Commands\Serve(
                $this->app->make("refresh.refresh")
            );
        });

        $this->commands("refresh.command.serve");
    }
    public function provides()
    {
        return [
            "refresh.refresh",
            "refresh.command.serve",
            "refresh.emitter",
            "refresh.server"
        ];
    }
}
