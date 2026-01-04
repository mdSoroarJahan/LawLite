<?php
// PHPStan stubs for common Eloquent methods to reduce false positives.
// These files are never loaded at runtime; they are only used by PHPStan.

namespace Illuminate\Database\Eloquent {

    use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

    /**
     * Minimal Model static method stubs used by PHPStan to resolve common calls.
     *
     * @method static \Illuminate\Database\Eloquent\Builder where(string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method static static create(array<string,mixed> $attributes = [])
     * @method static static find(mixed $id, array<int,string> $columns = ['*'])
     * @method static static findOrFail(mixed $id)
     * @method static static firstOrCreate(array<string,mixed> $attributes)
     * @method static \Illuminate\Database\Eloquent\Builder latest(string $column = 'created_at')
     * @method static \Illuminate\Database\Eloquent\Builder orderBy(string $column, string $direction = 'asc')
     * @method static \Illuminate\Database\Eloquent\Builder limit(int $value)
     * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate(?int $perPage = null, array<int,string> $columns = ['*'])
     */
    class Model
    {
        /**
         * Create a new model
         * @param array<string,mixed> $attributes
         * @return static
         */
        public static function create(array $attributes = []) {}

        /**
         * Start a query with a where
         * @param string $column
         * @param mixed $operator
         * @param mixed $value
         * @param string $boolean
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public static function where(string $column, $operator = null, $value = null, string $boolean = 'and') {}

        /**
         * Find a model by primary key
         * @param mixed $id
         * @param array<int,string> $columns
         * @return static|null
         */
        public static function find($id, array $columns = ['*']) {}

        /**
         * Find or fail
         * @param mixed $id
         * @return static
         */
        public static function findOrFail($id) {}

        /** @return \Illuminate\Database\Eloquent\Builder */
        public static function latest(string $column = 'created_at') {}

        /** @return \Illuminate\Database\Eloquent\Builder */
        public static function orderBy(string $column, string $direction = 'asc') {}

        /** @return \Illuminate\Database\Eloquent\Builder */
        public static function limit(int $value) {}

        /**
         * @param int|null $perPage
         * @param array<int,string> $columns
         * @return LengthAwarePaginatorContract
         */
        public static function paginate($perPage = null, array $columns = ['*']) {}

        /**
         * @param array<string,mixed> $attributes
         * @return static
         */
        public static function firstOrCreate(array $attributes) {}
    }

    class Builder {}
}

namespace Illuminate\Database\Eloquent {
    class Collection extends \Illuminate\Support\Collection {}
}

namespace Illuminate\Support {
    /**
     * Minimal stub for Collection so PHPStan recognizes the class used by eloquent stubs.
     * Keep it plain to avoid ArrayObject generic type complaints.
     */
    class Collection {}
}
