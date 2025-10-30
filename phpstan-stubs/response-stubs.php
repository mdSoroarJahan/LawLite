<?php
// PHPStan stubs for ResponseFactory and Response helper methods used in controllers
namespace Illuminate\Contracts\Routing {

    use Illuminate\Http\JsonResponse;

    interface ResponseFactory
    {
        /**
         * Create a new JSON response
         * @param mixed $data
         * @param int $status
         * @param array<string,string>|null $headers
         * @phpstan-param array<string,string>|null $headers
         * @param int $options
         * @return JsonResponse
         */
        public function json($data = null, int $status = 200, ?array $headers = null, int $options = 0);
    }
}

namespace Illuminate\Http {
    class Response
    {
        /**
         * Add a header and return the response
         * @param string $key
         * @param string $value
         * @return $this
         */
        public function header(string $key, string $value) {}

        /**
         * Return a JSON response
         * @param mixed $data
         * @param int $status
         * @param array<string,string>|null $headers
         * @phpstan-param array<string,string>|null $headers
         * @param int $options
         * @return JsonResponse
         */
        public function json($data = null, int $status = 200, ?array $headers = null, int $options = 0) {}
    }

    class JsonResponse extends Response
    {
        /** @return $this */
        public function header(string $key, string $value) {}
    }
}

namespace Illuminate\Contracts\Pagination {
    interface LengthAwarePaginator
    {
        /** @return $this */
        public function withQueryString();
    }
}

namespace Illuminate\Http {
    class RedirectResponse
    {
        /**
         * @param string $key
         * @param mixed $value
         * @return $this
         */
        public function with(string $key, $value) {}
    }
}

namespace Illuminate\Routing {
    // Minimal Redirector stub so method calls like ->with() and ->intended() resolve in PHPStan
    class Redirector
    {
        /**
         * @param string $key
         * @param mixed $value
         * @return \Illuminate\Http\RedirectResponse
         */
        public function with(string $key, $value) {}

        /**
         * @param string $default
         * @return \Illuminate\Http\RedirectResponse
         */
        public function intended($default = '/') {}
    }
}

namespace {
    /**
     * Helper stub for the global response() helper.
     *
     * This is intentionally permissive for PHPStan stubbing; callers should use
     * the ResponseFactory methods defined above (e.g. json()).
     *
     * @param mixed ...$args
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|null
     */
    function response(mixed ...$args): \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|null
    {
        // This stub is not executed at runtime; keep it parseable for PHPStan.
        return null;
    }
}
