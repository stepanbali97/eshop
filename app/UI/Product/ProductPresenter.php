<?php

declare(strict_types=1);

namespace App\UI\Product;

use Nette;
use Nette\Application\UI\Presenter;
use App\Models\DbFacade;

final class ProductPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
            private DbFacade $facade,
    ) {
        
    }
    
    public function renderDetail($productId) 
    {
         $this->template->product = $this->facade
                 ->getProduct($productId);
    }
}
