<?php
require __DIR__ . '/../vendor/autoload.php';
/** @var class-string $class */
$class = '\\App\\Console\\Commands\\DevSeedUsers';
if (class_exists($class)) { // @phpstan-ignore-line
    echo "FOUND" . PHP_EOL;
} else {
    echo "NOTFOUND" . PHP_EOL;
    // Attempt to require file directly
    $file = __DIR__ . '/../app/Console/Commands/DevSeedUsers.php';
    if (file_exists($file)) { // @phpstan-ignore-line
        echo "file exists\n";
        require $file;
        if (class_exists($class)) {
            echo "FOUND_AFTER_REQUIRE\n";
        } else {
            echo "STILL_NOT_FOUND\n";
        }
    }
}
