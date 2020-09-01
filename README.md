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
KONDUTO_DEBUG=true 
KONDUTO_PUBLIC_KEY=SUA_CHAVE_PUBLICA_FORNECIDA_PELA_KONDUTO
KONDUTO_PRIVATE_KEY=SUA_CHAVE_PRIVADA_FORNECIDA_PELA_KONDUTO
```

Você também pode customizar as configurações diretamente no arquivo de configuração, utilizando o comando abaixo:

```
php artisan vendor:publish --provider="RodrigoPedra\LaravelKonduto\KondutoServiceProvider"
```

Ele irá gerar o arquivo `config/laravel-konduto.php` na sua aplicação Laravel.
