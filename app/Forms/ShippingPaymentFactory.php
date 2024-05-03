<?php

declare (strict_types=1);

namespace App\Forms;

use App\Forms\FormFactory;
use Nette\Application\UI\Form;
use \App\Helper\BasketHelper;
use App\Helper\ShippingHelper;
use App\Helper\PaymentHelper;

/**
 * Description of ShippingPaymentFactory
 *
 * @author stepanbalatka
 */
final class ShippingPaymentFactory {

    public function __construct(
            private FormFactory $formFactory,
            private BasketHelper $helper,
            private ShippingHelper $shipping,
            private PaymentHelper $payment,
    ) {
        
    }

    public function create(): Form {
        $data = $this->helper->getBasket();

        $shipping = $this->shipping->getShipping();

        $payment = $this->payment->getPayment();

        $form = $this->formFactory->createForm();
        $form->addRadioList('shipping_type', 'Doprava:', $shipping)->setDefaultValue($data->shipping_type)->setRequired('Zvol způsob dopravy.');
        $form->addRadioList('payment_type', 'Platba:', $payment)->setDefaultValue($data->payment_type)->setRequired('Zvol způsob platby.');

        $form->addSubmit('submit', 'Pokračovat k rekapitulaci objednávky');

        $form->onSuccess[] = $this->shippingPaymentFormSucceeded(...);

        return $form;
    }

    public function shippingPaymentFormSucceeded(array $data): void {

        $this->helper->getBasket()->update($data);
    }
}   