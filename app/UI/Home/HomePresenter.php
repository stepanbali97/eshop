<?php

declare(strict_types=1);

namespace app\UI\Home;

use Nette\Application\UI\Presenter;
use App\Models\DbFacade;
use Nette\Application\UI\Multiplier;
use App\Forms\AddItemToBasketFormFactory;

final class HomePresenter extends Presenter {

    public function __construct(
            private DbFacade $facade,
            private AddItemToBasketFormFactory $formFactory,
    ) {
        
    }

    public function renderDefault(): void {
        $this->template->products = $this->facade
                ->getAllProducts();
    }

    protected function createComponentAddToBasketForm(): Multiplier {
        return new Multiplier(function ($productId) {
                    $form = $this->formFactory->create((int) $productId);
                    $form->onSuccess[] = function () {

                        $this->flashMessage("Produkt je v košíku!", 'success');
                        $this->redirect('Basket:default');
                    };
                    return $form;
                });
    }
}
