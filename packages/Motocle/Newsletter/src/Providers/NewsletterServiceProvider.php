<?php

namespace Motocle\Newsletter\Providers;

use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        include __DIR__ . '/../Http/routes.php';

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'newsletter');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'newsletter');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );
    }
}
