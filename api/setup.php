<?php

// Setup script for Vercel deployment
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set up SQLite database for Vercel
$dbPath = '/tmp/database.sqlite';

if (!file_exists($dbPath)) {
    // Create SQLite database
    touch($dbPath);

    // Run migrations
    $artisan = $app->make(Illuminate\Contracts\Console\Kernel::class);

    // Set database path in config
    config(['database.connections.sqlite.database' => $dbPath]);

    try {
        // Run migrations
        $artisan->call('migrate', ['--force' => true]);

        // Seed the database
        $artisan->call('db:seed', ['--force' => true]);

        echo "Database setup completed successfully!";
    } catch (Exception $e) {
        echo "Database setup failed: " . $e->getMessage();
    }
} else {
    echo "Database already exists.";
}