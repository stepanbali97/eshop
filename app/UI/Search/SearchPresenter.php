<?php

declare (strict_types=1);

namespace App\UI\ShippingPayment;

use Nette\Application\UI\Presenter;
use App\Models\DbFacade;
use \App\Forms\SearchFormFactory;
use Nette\Application\UI\Form;

/**
 * Description of SearchPresenter
 *
 * @author stepanbalatka
 */
final class SearchPresenter extends Presenter {

    public function __construct(
            private DbFacade $facade,
            private SearchFormFactory $formFactory,
    ) {
        
    }
    
    protected function createComponentSearchForm(): Form {

        $form = $this->formFactory->create();   

        $form->onSuccess[] = $this->searchFormSucceeded(...);
        return $form;
    }

    private function searchFormSucceeded(Form $form, $values) {

        $productName = (string) ($values['name']->getValue());

        $searchQuery = $this->facade->fulltextSearch($productName);

        if ($searchQuery == null) {
            $form->errors('Produkt s tímto názvem neexistuje.');
        } else {
            $this->flashMessage('Zde je hledaný produkt');
            $this->template->searchQuery = $searchQuery;
        }
    }
    
   
}
