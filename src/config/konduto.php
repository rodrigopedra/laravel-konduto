<?php

return [
    'environment' => env( 'KONDUTO_ENVIRONMENT', 'production' ), // 'production' or 'sandbox'
    'debug'       => env( 'KONDUTO_DEBUG', true ),
    'public_key'  => env( 'KONDUTO_PUBLIC_KEY', '' ),
    'private_key' => env( 'KONDUTO_PRIVATE_KEY', '' ),
];
