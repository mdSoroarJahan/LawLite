<?php

// Ensure required storage directories exist for tests and local runs.
$root = dirname(__DIR__);
$storage = $root . DIRECTORY_SEPARATOR . 'storage';

$dirs = [
    $storage . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'sessions',
    $storage . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'views',
    $storage . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'cache',
    $storage . DIRECTORY_SEPARATOR . 'logs',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Try to set permissive permissions where possible (no-op on Windows sometimes)
@chmod($storage, 0777);
foreach ($dirs as $dir) {
    @chmod($dir, 0777);
}

echo "test-prepare: ensured storage dirs\n";
