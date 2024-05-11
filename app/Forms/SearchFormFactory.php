<?php

declare (strict_types=1);

namespace App\Forms;

use App\Models\DbFacade;
use App\Forms\FormFactory;
use Nette\Application\UI\Form;

/**
 * Description of SearchFormFactory
 *
 * @author stepanbalatka
 */
final class SearchFormFactory {
    
    public function __construct(
            private FormFactory $formFactory,
            private DbFacade $facade,
    ) {
        
    }

    public function create(): Form {
        $form = $this->formFactory->createForm();
        $form->addText('name', 'Název:')->setRequired();
        $form->addSubmit('search', 'Hledej');

        $form->onSuccess[] = $this->searchFormSucceeded(...);

        return $form;
    }
    
  
}
