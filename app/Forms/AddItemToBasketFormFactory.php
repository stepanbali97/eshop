<?php

declare (strict_types=1);

namespace App\Forms;

use App\Models\DbFacade;
use App\Forms\FormFactory;
use Nette\Application\UI\Form;
use App\Helper\BasketHelper;

/**
 * Description of AddItemToBasketFormFactory
 *
 * @author stepanbalatka
 */
final class AddItemToBasketFormFactory {
    
    public function __construct(
            private FormFactory $formFactory,
            private DbFacade $facade,
            private BasketHelper $helper,
    ) {
        
    }

    public function create(?int $productId): Form {
        $form = $this->formFactory->createForm();
        $form->addHidden('product_id', $productId);
        $form->addSubmit('send', 'Přidat do košíku');
        $form->onSuccess[] = $this->addToBasketSucceeded(...);

        return $form;
    }

    public function addToBasketSucceeded($values): void {
        $basket = $this->helper->getBasket();

        // Get product details from the form
        
        $productId = (int) ($values['product_id']->getValue());

        $product = $this->facade->getProduct($productId);
        if ($product === null) {
            $this->error('Produkt nebyl nalezen');
        }
        
        $basketItem = $this->facade->getProductInBasket($product->id, $basket->id);
        if ($basketItem === null) {
            $this->facade->addItemToBasket($product, $basket);
        }
    }
}
