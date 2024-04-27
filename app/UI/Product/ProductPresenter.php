<?php

declare(strict_types=1);

namespace App\UI\Product;

use Nette;
use Nette\Application\UI\Presenter;
use App\Models\DbFacade;
use Nette\Application\UI\Form;


final class ProductPresenter extends Presenter {

    private $productId = null;


    public function __construct(
            private DbFacade $facade,
            private \App\Helper\BasketHelper $helper,
    ) {
        
    }

    public function renderDetail($productId) {
        $this->template->product = $this->facade
                ->getProduct((int)$productId);
        $this->productId = (int)$productId;
    }

    protected function createComponentProductForm(): Form {
        $form = new Form();

        $form->addHidden('product_id', $this->productId);
        $form->addSubmit('send', 'Přidat do košíku');
        $form->onSuccess[] = $this->addToBasket(...);

        return $form;
    }

    public function addToBasket($values): void {
        $basket = $this->helper->getBasket();

        // Get product details from the form
        $productId = (int)($values['product_id']->getValue());

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
