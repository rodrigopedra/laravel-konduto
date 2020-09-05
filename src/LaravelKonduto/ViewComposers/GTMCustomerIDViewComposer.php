<?php

namespace RodrigoPedra\LaravelKonduto\ViewComposers;

use Illuminate\Contracts\View\View;
use RodrigoPedra\LaravelKonduto\KondutoService;

class GTMCustomerIDViewComposer
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
        $view->with('customerId', $this->kondutoService->getCustomerId());
    }
}
