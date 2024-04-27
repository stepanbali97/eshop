<?php

declare (strict_types=1);

namespace App\UI\Basket;

use Nette\Application\UI\Presenter;

/**
 * Description of BasketPresenter
 *
 * @author stepanbalatka
 */
final class BasketPresenter extends Presenter {

    public function __construct(
            private \App\Models\DbFacade $facade,
            private \App\Helper\BasketHelper $helper,
    ) {
        
    }
//facade + přejmenovat na acquireBasket
    

    /*
     * Zjistí jestli v session existuje košík, pokud ne, tak ho vytvoří nový a následně pošle do šablony itemy
     *  
     */
//zde
    public function renderDefault(): void {
        $basket = $this->helper->getBasket();

        //pro košík vytáhnu a připravím všechny položky
        $basketItems = $this->facade->getBasketItems($basket->id);
        $this->template->basketItems = $basketItems;
    }
//detail
    

    
}
