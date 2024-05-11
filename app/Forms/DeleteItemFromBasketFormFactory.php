<?php

declare (strict_types=1);

namespace App\Forms;

use App\Models\DbFacade;
use App\Forms\FormFactory;
use Nette\Application\UI\Form;
use App\Helper\BasketHelper;

/**
 * Description of DeleteItemFromBasket
 *
 * @author stepanbalatka
 */
final class DeleteItemFromBasketFormFactory {

    public function __construct(
            private FormFactory $formFactory,
            private DbFacade $facade,
            private BasketHelper $helper,
    ) {
        
    }

    public function create(?int $productId): Form {
        $form = $this->formFactory->createForm();
        $form->addHidden('products_id', $productId);
        $form->addSubmit('submit', 'Vymazat');
        $form->onSuccess[] = $this->deleteItemSucceeded(...);

        return $form;
    }

    public function deleteItemSucceeded($values): void {

        $basket = $this->helper->getBasket();
        
        $productId = (int) ($values['products_id']->getValue());
        
        $basketId = $basket->id;
        
        $this->facade->deleteItemFromBasket((int) $productId, $basketId);
    }
}

