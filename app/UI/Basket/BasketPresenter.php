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

    /*
     * Zjistí jestli v session existuje košík, pokud ne, tak ho vytvoří nový a následně pošle do šablony itemy
     *  
     */

    public function renderDefault(): void {
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

        //pro košík vytáhnu a připravím všechny položky
        $basketItems = $this->facade->getBasketItems($basket->id);
        $this->template->basketItems = $basketItems;
    }

    /*
      protected function createComponentProductForm(): Form
      {
      $form = new Form();

      $form->addHidden('id');
      $form->addHidden('name');
      $form->addHidden('price_doge');
      $form->addSubmit('send', 'Přidat do košíku');
      $form->onSuccess[] = $this->addToBasketSucceeded(...);

      return $form;
      }
     */
    /*
      public function addToBasket(Form $form, array $values): void
      {
      // Start or resume the session
      $this->getSession()->start();

      // Get product details from the form
      $productId = $values['product_id'];
      $productName = $values['product_name'];
      $productPrice = $values['product_price'];

      // Initialize basket in session if not exists
      if (!isset($_SESSION['basket'])) {
      $_SESSION['basket'] = [];
      }

      // Add product to basket
      $_SESSION['basket'][] = [
      'id' => $productId,
      'name' => $productName,
      'price' => $productPrice
      ];

      // Redirect back to product detail page or wherever you want
      $this->redirect('this');
      }
     */

    //druhá metoda která udělá insert do košíku (id produktu a id košíku) zjistim existenci košíku
}
