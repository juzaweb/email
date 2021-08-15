<?php

namespace Juzaweb\Email\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Core\Facades\HookAction;
use Juzaweb\Email\Commands\SendMailCommand;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        HookAction::loadActionForm(__DIR__ . '/../../actions');
        $this->loadViewsFrom(__DIR__ . '/../views', 'jw_email');

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('email:send')->everyMinute();
        });
    }
    
    public function register()
    {
        $this->commands([
            SendMailCommand::class,
        ]);
    }
}
