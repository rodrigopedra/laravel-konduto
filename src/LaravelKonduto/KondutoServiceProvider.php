<?php

namespace RodrigoPedra\LaravelKonduto;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class KondutoServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->bootViews();

        $this->publishes( [
            __DIR__ . '/../resources/config/laravel-konduto.php' => $this->app->configPath( 'laravel-konduto.php' ),
        ], 'config' );
    }

    public function register()
    {
        $this->mergeConfigFrom( __DIR__ . '/../resources/config/laravel-konduto.php', 'laravel-konduto' );

        $this->app->singleton( 'konduto', function () {
            return new KondutoService(
                $this->app[ 'request' ],
                $this->app[ 'config' ]->get( 'laravel-konduto.public_key' ),
                $this->app[ 'config' ]->get( 'laravel-konduto.private_key' ),
                $this->app[ 'config' ]->get( 'laravel-konduto.debug' ) ? $this->app[ 'log' ] : null
            );
        } );

        $this->app->alias( 'konduto', KondutoService::class );
    }

    private function bootViews()
    {
        $this->loadViewsFrom( __DIR__ . '/../resources/views', 'konduto' );

        View::composer( 'konduto::base-script', function ( $view ) {
            /** @var KondutoService $service */
            $service = $this->app->make( 'konduto' );

            $view->with( 'publicKey', $service->getPublicKey() );
        } );

        View::composer( 'konduto::gtm-customer-id', function ( $view ) {
            /** @var KondutoService $service */
            $service = $this->app->make( 'konduto' );

            $view->with( 'customerId', $service->getCustomerId() );
        } );
    }
}
