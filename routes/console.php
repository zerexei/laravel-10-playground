<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('prod', function () {
    // !# PHP ARTISAN TEST
    $run_artisan_test = Process::run('php artisan test');
    if ($run_artisan_test->failed()) {
        $this->info($run_artisan_test->output());
        $this->info("php artisan test failed.");
        return;
    }
    $this->info("php artisan test successful.");

    // !# NPM RUN TEST
    $npm_run_test = Process::run('npm run test');
    if ($npm_run_test->failed()) {
        $this->info($npm_run_test->output());
        $this->info("npm test failed.");
        return;
    }
    $this->info("npm test successful.");

    // !# NPM RUN BUILD
    $npm_build = Process::run('npm run build');
    if ($npm_build->failed()) {
        $this->info($npm_build->output());
        return;
    }
    $this->info("npm build successful.");

    // !# OTHER OPTIMIZATION

    // UPDATE PROD FILE
    if (file_exists(resource_path('/views/welcome.blade.prod.php'))) {
        $entry_file = "resources/views/welcome.blade.php";
        $prod_file = "resources/views/welcome.blade.prod.php";
        $dev_file = "resources/views/welcome.blade.dev.php";
        Process::run("mv $entry_file $dev_file");
        Process::run("mv $prod_file $entry_file");
    }
    $this->info("ready for production :)");
});

Artisan::command('dev', function () {
    $entry_file = "resources/views/welcome.blade.php";
    $prod_file = "resources/views/welcome.blade.prod.php";
    $dev_file = "resources/views/welcome.blade.dev.php";
    if (file_exists(resource_path('/views/welcome.blade.dev.php'))) {
        Process::run("mv $entry_file $prod_file");
        Process::run("mv $dev_file $entry_file");
    }
});
