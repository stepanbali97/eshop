<?php

declare (strict_types=1);

namespace app\UI\SearchResult;

use Nette\Application\UI\Presenter;
use App\Models\DbFacade;
use \App\Forms\SearchFormFactory;
use Nette\Application\UI\Form;


/**
 * Description of SearchResultPresenter
 *
 * @author stepanbalatka
 */
final class SearchResultPresenter extends Presenter {
    public function __construct(
            private DbFacade $facade,
            private SearchFormFactory $formFactory,
    ) {
        
    }
    
    public function renderDefault($searchQuery): void {
        
        $this->template->searchQueries = $searchQuery;
    }
}

/*
 private function searchFormSucceeded(Form $form, $values) {

        $productName = (string) ($values['name']);

        $searchQuery = $this->facade->fulltextSearch($productName);

        if ($searchQuery === null) {
            $form->addError('Produkt s tímto názvem neexistuje.');
        } else {
            $this->flashMessage('Zde je hledaný dotaz');
            $this->redirect('SearchResult:default'); // nově přidáno
            // $this->template->searchQueries = $searchQuery;
        }
    }
  */
 