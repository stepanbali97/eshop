<?php

declare (strict_types=1);

namespace App\UI\ShippingPayment;

use Nette\Application\UI\Presenter;
use \Nette\Application\UI\Form;
use \App\Models\DbFacade;
use \App\Helper\BasketHelper;
use App\Helper\ShippingHelper;
use App\Helper\PaymentHelper;
/**
 * Description of ShippingPaymentPresenter
 *
 * @author stepanbalatka
 */
final class ShippingPaymentPresenter extends Presenter
{
    public function __construct(
            private DbFacade $facade,
            private BasketHelper $helper,
            private ShippingHelper $shipping,
            private PaymentHelper $payment,
    ) {
        
    }

    protected function createComponentShippingPaymentForm(): Form {
        $data = $this->helper->getBasket();
        
       $shipping = $this->shipping->getShipping();
       
       $payment = $this->payment->getPayment();
        
        $form = new Form;
        
        $form->addRadioList ('shipping_type', 'Doprava:', $shipping)->setDefaultValue($data->shipping_type)->setRequired('Zvol způsob dopravy.');
        $form->addRadioList ('payment_type', 'Platba:', $payment)->setDefaultValue($data->payment_type)->setRequired('Zvol způsob platby.');
        
        $form->addSubmit('submit', 'Pokračovat k rekapitulaci objednávky');

        $form->onSuccess[] = $this->shippingPaymentFormSucceeded(...);

        return $form;
    }

    private function shippingPaymentFormSucceeded(array $data): void {
        
        $this->helper->getBasket()->update($data);
        
       
        $this->redirect('Rekapitulation:default');
    }
 
}

