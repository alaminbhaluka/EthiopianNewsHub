<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$connection = \Illuminate\Support\Facades\DB::connection();
$usesPostgresLock = $connection->getDriverName() === 'pgsql';
$lockKey = 5720261123;

if ($usesPostgresLock) {
    $connection->select('SELECT pg_advisory_lock(?)', [$lockKey]);
}

try {
    $exitCode = \Illuminate\Support\Facades\Artisan::call('migrate', [
        '--force' => true,
        '--no-interaction' => true,
    ]);

    echo \Illuminate\Support\Facades\Artisan::output();

    if ($exitCode !== 0) {
        exit($exitCode);
    }
} finally {
    if ($usesPostgresLock) {
        $connection->select('SELECT pg_advisory_unlock(?)', [$lockKey]);
    }
}
