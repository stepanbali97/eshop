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
    ) {
        
    }
//facade + přejmenovat na acquireBasket
    private function getBasket() {
        if (array_key_exists('basket_id', $_SESSION)) {
            $basketId = $_SESSION['basket_id'];
            $basket = $this->facade->getBasket($basketId);

            if ($basket === null) { //ošetřit zda opravdu existuje id košíku
                $basket = $this->facade->createBasket();
                $_SESSION['basket_id'] = $basket->id;
            }
        } else {
            $basket = $this->facade->createBasket();
            $_SESSION['basket_id'] = $basket->id;
        }
        return $basket;
    }

    /*
     * Zjistí jestli v session existuje košík, pokud ne, tak ho vytvoří nový a následně pošle do šablony itemy
     *  
     */
//zde
    public function renderDefault(): void {
        $basket = $this->getBasket();

        //pro košík vytáhnu a připravím všechny položky
        $basketItems = $this->facade->getBasketItems($basket->id);
        $this->template->basketItems = $basketItems;
    }
//detail
    protected function createComponentProductForm(): Form {
        $form = new Form();

        $form->addHidden('product_id');
        $form->addSubmit('send', 'Přidat do košíku');
        $form->onSuccess[] = $this->addToBasket(...);

        return $form;
    }

    public function addToBasket($values): void {
        $basket = $this->getBasket();

        // Get product details from the form
        $productId = $values['product_id'];

        $product = $this->facade->getProduct($productId);
        if ($product === null) {
            $this->error('Produkt nebyl nalezen');
        }
        $basketItem = $this->facade->getProductInBasket($product->id, $basket->id);
        if ($basketItem === null) {
            $this->facade->addItemToBasket($product, $basket);
        }
        $this->flashMessage("Produkt je v košíku!", 'success');

        // Redirect back to product detail page or wherever you want
        $this->redirect('Basket:default');
    }

    
}
