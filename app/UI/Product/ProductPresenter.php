<?php

declare(strict_types=1);

namespace App\UI\Product;

use Nette;
use Nette\Application\UI\Presenter;
use App\Models\DbFacade;
use Nette\Application\UI\Form;
use App\Forms\AddItemToBasketFormFactory;

final class ProductPresenter extends Presenter {

    private $productId = null;

    public function __construct(
            private DbFacade $facade,
            private AddItemToBasketFormFactory $formFactory,
    ) {
        
    }

    protected function createComponentAddItemToBasketForm(): Form {
        $form = $this->formFactory->create($this->productId);
        $form->onSuccess[] = function () {

            $this->flashMessage("Produkt je v košíku!", 'success');
            $this->redirect('Basket:default');
        };
        return $form;
    }

    public function renderDetail(int $productId) {
        $this->template->product = $this->facade
                ->getProduct((int) $productId);
        $this->productId = (int) $productId;
    }
}
