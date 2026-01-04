<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Bind a GeminiService stub that throws GeminiException
// Bind a concrete subclass of GeminiService so type-hinting matches
$app->bind(App\Services\GeminiService::class, function () {
    return new class extends App\Services\GeminiService {
        // Keep signatures compatible with the parent service
        public function askQuestion(string $question, ?string $language = null): ?array
        {
            throw new App\Exceptions\GeminiException('simulated upstream error');
        }

        public function summarize(array $documentFiles, ?string $language = null): ?array
        {
            throw new App\Exceptions\GeminiException('simulated upstream error');
        }
    };
});

// Make http kernel and simulate POST /ai/question with JSON accept header
// Call the controller directly to avoid CSRF/session middleware during simulation
$controller = $app->make(App\Http\Controllers\AiController::class);

$request = Illuminate\Http\Request::create('/ai/question', 'POST', ['question' => 'Hello?']);
$request->headers->set('Accept', 'application/json');

try {
    $response = $controller->ask($request);
} catch (Throwable $e) {
    // Let the global handler render the exception as an HTTP response
    $handler = $app->make(App\Exceptions\Handler::class);
    $response = $handler->render($request, $e);
}

echo "ASK endpoint status: " . $response->getStatusCode() . PHP_EOL;
foreach ($response->headers->all() as $k => $vals) {
    echo $k . ": " . implode(', ', $vals) . PHP_EOL;
}

echo "Body:\n" . $response->getContent() . PHP_EOL;

// Now test summarize
$request2 = Illuminate\Http\Request::create('/ai/summarize', 'POST', ['documents' => ['a']]);
$request2->headers->set('Accept', 'application/json');

try {
    $response2 = $controller->summarize($request2);
} catch (Throwable $e) {
    $handler = $app->make(App\Exceptions\Handler::class);
    $response2 = $handler->render($request2, $e);
}

echo "\nSUMMARIZE endpoint status: " . $response2->getStatusCode() . PHP_EOL;
foreach ($response2->headers->all() as $k => $vals) {
    echo $k . ": " . implode(', ', $vals) . PHP_EOL;
}

echo "Body:\n" . $response2->getContent() . PHP_EOL;
