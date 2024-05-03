<?php

declare (strict_types=1);

namespace App\UI\ShippingPayment;

use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use App\Forms\ShippingPaymentFactory;

/**
 * Description of ShippingPaymentPresenter
 *
 * @author stepanbalatka
 */
final class ShippingPaymentPresenter extends Presenter {

    public function __construct(
            private ShippingPaymentFactory $formFactory,
    ) {
        
    }

    protected function createComponentShippingPaymentForm(): Form {
        $form = $this->formFactory->create();
        $form->onSuccess[] = function () {
            $this->redirect('Rekapitulation:default');
        };
        return $form;
    }
}
