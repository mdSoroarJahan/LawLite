<?php

return [
    'hosts' => [env('ELASTICSEARCH_HOST', 'http://127.0.0.1:9200')],
    'index' => env('ELASTICSEARCH_INDEX', 'lawlite'),
];
