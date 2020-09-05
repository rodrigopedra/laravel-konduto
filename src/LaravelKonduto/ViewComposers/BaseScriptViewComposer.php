<?php

namespace RodrigoPedra\LaravelKonduto\ViewComposers;

use Illuminate\Contracts\View\View;
use RodrigoPedra\LaravelKonduto\KondutoService;

class BaseScriptViewComposer
{
    /**
     * @var \RodrigoPedra\LaravelKonduto\KondutoService
     */
    private $kondutoService;

    public function __construct(KondutoService $kondutoService)
    {
        $this->kondutoService = $kondutoService;
    }

    public function compose(View $view): void
    {
        $view->with('publicKey', $this->kondutoService->getPublicKey());
    }
}
