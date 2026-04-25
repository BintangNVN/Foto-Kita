<?php

// Vercel deployment entry point for Laravel
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set up Laravel for Vercel
$app->bind('request', function () {
    return Illuminate\Http\Request::capture();
});

// Handle the request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);