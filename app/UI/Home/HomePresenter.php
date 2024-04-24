<?php

declare(strict_types=1);

namespace App\UI\Home;

use Nette;
use Nette\Application\UI\Presenter;
use App\Models\DbFacade;

final class HomePresenter extends Nette\Application\UI\Presenter {

    public function __construct(
            private DbFacade $facade,
    ) {
        
    }

    public function renderDefault(): void {
        $this->template->products = $this->facade
                ->getAllProducts();
    }
}
