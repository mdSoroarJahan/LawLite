<?php
// PHPStan stubs for ResponseFactory and Response helper methods used in controllers
namespace Illuminate\Contracts\Routing {

    use Illuminate\Http\JsonResponse;

    interface ResponseFactory
    {
        /**
         * Create a new JSON response
         * @param mixed $data
         * @return JsonResponse
         */
        public function json($data = null, int $status = 200, array $headers = [], int $options = 0);
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
         * @return JsonResponse
         */
        public function json($data = null, int $status = 200, array $headers = [], int $options = 0) {}
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
        /** @return $this */
        public function with(string $key, $value) {}
    }
}

namespace Illuminate\Routing {
    // Minimal Redirector stub so method calls like ->with() and ->intended() resolve in PHPStan
    class Redirector
    {
        /** @return \Illuminate\Http\RedirectResponse */
        public function with(string $key, $value) {}

        /** @return \Illuminate\Http\RedirectResponse */
        public function intended($default = '/') {}
    }
}
