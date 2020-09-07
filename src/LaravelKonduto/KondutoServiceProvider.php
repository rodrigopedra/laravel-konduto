<?php

namespace RodrigoPedra\LaravelKonduto;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use RodrigoPedra\LaravelKonduto\ViewComposers\BaseScriptViewComposer;
use RodrigoPedra\LaravelKonduto\ViewComposers\GTMCustomerIDViewComposer;

class KondutoServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot(Factory $viewFactory): void
    {
        $this->bootConfig();
        $this->bootViews($viewFactory);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-konduto.php', 'laravel-konduto');

        $this->app->singleton(KondutoService::class, static function (Container $container): KondutoService {
            $request = $container->make(Request::class);
            $config = $container->make(Repository::class);
            $logger = $config->get('laravel-konduto.debug', true) === true
                ? $container->make(LoggerInterface::class)
                : null;

            return new KondutoService(
                $request,
                $config->get('laravel-konduto.public_key'),
                $config->get('laravel-konduto.private_key'),
                $logger
            );
        });

        $this->app->alias(KondutoService::class, 'konduto');
    }

    private function bootConfig(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-konduto.php' => $this->app->configPath('laravel-konduto.php'),
            ], 'laravel-konduto-config');
        }
    }

    private function bootViews(Factory $viewFactory): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'konduto');

        $viewFactory->composer('konduto::base-script', BaseScriptViewComposer::class);
        $viewFactory->composer('konduto::gtm-customer-id', GTMCustomerIDViewComposer::class);
    }

    public function provides(): array
    {
        return [
            KondutoService::class,
            'konduto',
        ];
    }
}
