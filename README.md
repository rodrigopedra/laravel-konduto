# API Konduto

Este pacote é um *thin-wrapper* para Laravel do SDK disponibilizado oficialmente em:

https://github.com/konduto/php-sdk

## Requisitos

PHP 5.5+

## Instalação

A maneira mais fácil de instalar a biblioteca é através do [Composer](http://getcomposer.org/).

```JSON
{
    "require": {
        "rodrigopedra/laravel-konduto": "^0.1"
    }
}
```

## Configuração

Adicione ao seu arquivo `.env` os seguintes valores

```
KONDUTO_ENVIRONMENT=production
KONDUTO_DEBUG=true 
KONDUTO_PUBLICK_KEY=SUA_CHAVE_PUBLICA_FORNECIDA_PELA_KONDUTO
KONDUTO_PRIVATE_KEY=SUA_CHAVE_PRIVADA_FORNECIDA_PELA_KONDUTO
```

Adicione ao seu arquivo `config/services.php` as seguintes configurações

```php
<?php
    
return [

    // outros serviços
    
    'konduto' => [
        'environment' => env( 'KONDUTO_ENVIRONMENT', 'production' ), // 'production' or 'sandbox'
        'debug' => env('KONDUTO_DEBUG', true), // true ou false indicando se você quer logar os requests
        'public' => env('KONDUTO_PUBLIC_KEY'),
        'private' => env('KONDUTO_PRIVATE_KEY'),
    ],

];
```
