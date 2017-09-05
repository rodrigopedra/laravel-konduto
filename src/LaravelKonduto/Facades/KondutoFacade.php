<?php

namespace RodrigoPedra\LaravelKonduto\Facades;

use Illuminate\Support\Facades\Facade;

class KondutoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'konduto';
    }
}
