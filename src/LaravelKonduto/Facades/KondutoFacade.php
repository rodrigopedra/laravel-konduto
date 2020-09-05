<?php

namespace RodrigoPedra\LaravelKonduto\Facades;

use Illuminate\Support\Facades\Facade;
use RodrigoPedra\LaravelKonduto\KondutoService;

class KondutoFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return KondutoService::class;
    }
}
