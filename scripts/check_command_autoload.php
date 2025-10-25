<?php
require __DIR__ . '/../vendor/autoload.php';
$class = '\\App\\Console\\Commands\\DevSeedUsers';
if (class_exists($class)) {
    echo "FOUND" . PHP_EOL;
} else {
    echo "NOTFOUND" . PHP_EOL;
    // Attempt to require file directly
    $file = __DIR__ . '/../app/Console/Commands/DevSeedUsers.php';
    if (file_exists($file)) {
        echo "file exists\n";
        require $file;
        echo class_exists($class) ? "FOUND_AFTER_REQUIRE\n" : "STILL_NOT_FOUND\n";
    }
}
