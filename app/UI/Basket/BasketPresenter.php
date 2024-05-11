<?php

declare (strict_types=1);

namespace App\UI\Basket;

use Nette\Application\UI\Presenter;
use App\Models\DbFacade;
use Nette\Application\UI\Multiplier;
use App\Helper\BasketHelper;
use App\Forms\DeleteItemFromBasketFormFactory;

/**
 * Description of BasketPresenter
 *
 * @author stepanbalatka
 */
final class BasketPresenter extends Presenter {
    
    public function __construct(
            private DbFacade $facade,
            private BasketHelper $helper,
            private DeleteItemFromBasketFormFactory $formFactory,
    ) {
        
    }

    /*
     * Zjistí jestli v session existuje košík, pokud ne, tak ho vytvoří nový a následně pošle do šablony itemy
     *  
     */

    public function renderDefault(): void {
        $basket = $this->helper->getBasket();
        //$productId = $this->facade->getProduct();
        

        //pro košík vytáhnu a připravím všechny položky
        $basketItems = $this->facade->getBasketItems($basket->id,); 
        $this->template->basketItems = $basketItems;
    }

    //potřeba opravit pro delete produktu
    protected function createComponentDeleteItemFromBasketForm(): Multiplier {
        return new Multiplier(function ($productId) {
                    $form = $this->formFactory->create((int) $productId);
                    $form->onSuccess[] = function () {

                        $this->flashMessage("Produkt není v košíku!", 'success');
                        $this->redirect('Basket:');
                    };
                    return $form;
                });
    }
}