<?php

declare(strict_types=1);

namespace App\UI\Home;

use Nette;
use Nette\Application\UI\Presenter;
use App\Models\DbFacade;
use Nette\Application\UI\Form;
use  Nette\Application\UI\Multiplier;

final class HomePresenter extends Presenter {

    public function __construct(
            private DbFacade $facade,
    ) {
        
    }

    public function renderDefault(): void {
        $this->template->products = $this->facade
                ->getAllProducts();
    }
    
    protected function createComponentAddToBasketForm(): Multiplier
{ 
	return new Multiplier(function ($productId) { 
		$form = new Form;
		$form->addHidden('product_id', $productId);
		$form->addSubmit('send', 'Přidat do košíku');
                $form->onSuccess[] = $this->addToBasket(...);
		return $form;
	});
}

}
