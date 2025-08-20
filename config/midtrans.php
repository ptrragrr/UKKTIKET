<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false), // false = sandbox, true = production
    'is_sanitized' => true,
    'is_3ds' => true,
];

// return [
//     'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-RCvqUfOg8bIBHTbk9tmOAfHg'),
//     'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-esXCpTcSVjcsPsL2'),
//     'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
//     'is_sanitized' => true,
//     'is_3ds' => true,
// ];
