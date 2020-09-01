<?php

return [
    'debug'       => env( 'KONDUTO_DEBUG', true ), // true ou false indicando se você quer logar os requests
    'public_key'  => env( 'KONDUTO_PUBLIC_KEY' ),
    'private_key' => env( 'KONDUTO_PRIVATE_KEY' ),
];