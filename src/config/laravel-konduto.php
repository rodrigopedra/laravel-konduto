<?php

return [
    'debug' => \env('KONDUTO_DEBUG', true) === true,
    'public_key' => \env('KONDUTO_PUBLIC_KEY'),
    'private_key' => \env('KONDUTO_PRIVATE_KEY'),
];