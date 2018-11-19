<?php

return [
    'webcron_key' => env('WEBCRON_KEY', env('APP_KEY')),
    'online_check_interval' => 60 * 24,
];