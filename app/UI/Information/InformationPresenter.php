<?php

declare (strict_types=1);

namespace App\UI\Information;

use \Nette\Application\UI\Presenter;
use \Nette\Application\UI\Form;
use App\Forms\InformationFormFactory;

/**
 * Description of InformationPresenter
 *
 * @author stepanbalatka
 */
final class InformationPresenter extends Presenter {

    public function __construct(
            private InformationFormFactory $formFactory,
    ) {
        
    }

    protected function createComponentInformationForm(): Form {
        $form = $this->formFactory->create();
        $form->onSuccess[] = function () {
            $this->redirect('ShippingPayment:');
        };
        return $form;
    }
}
