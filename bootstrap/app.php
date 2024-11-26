<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Models\Rekom;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    //TODO Scheaduler
    // ->withSchedule(function (Schedule $schedule) {
    //     $rekom = new Rekom();
    //     // $allRekom = $rekom->sele

    //     $schedule
    //         ->command('inspire')
    //         ->everySecond();
        
    // })
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
