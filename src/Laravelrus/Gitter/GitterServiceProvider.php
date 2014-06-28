<?php namespace Laravelrus\Gitter;

use Illuminate\Support\ServiceProvider;

class GitterServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->package('laravelrus/gitter-bot', 'gitter');

        $this->app['router']->controller('/gitter', 'Laravelrus\Gitter\GitterController');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('gitter', function ()
        {
            $config = $this->app['config']->get('gitter::config');

            return new Gitter(
                $config['roomId'],
                $config['token']
            );
        });

        $this->app->singleton('Laravelrus\Gitter\Gitter', 'gitter');

        // Reqgister artisan command
        $this->commands('Laravelrus\Gitter\Commands\GitterCheckUsersCommand');
    }

}
