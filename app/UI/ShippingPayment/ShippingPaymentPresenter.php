<?php

declare (strict_types=1);

namespace App\UI\ShippingPayment;

use Nette\Application\UI\Presenter;
use \Nette\Application\UI\Form;
use \App\Models\DbFacade;
use \App\Helper\BasketHelper;
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
    ) {
        
    }

    protected function createComponentShippingPaymentForm(): Form {
        $data = $this->helper->getBasket();
        
        $choiceShipping = [
            '0' => 'Česká pošta',
            '1' => 'Osobní odběr',
            '2' => 'DPD',
            '3' => 'Zásilkovna',
        ];
        
         $choicePayment = [
            '0' => 'Převodem na bankovní účet',
            '1' => 'Kartou', 
            '2' => 'Kryptoměna DOGE',
        ];
        
        $form = new Form;
        
        $form->addRadioList ('shipping_type', 'Doprava:', $choiceShipping)->setDefaultValue($data->shipping_type)->setRequired('Zvol způsob dopravy.');
        $form->addRadioList ('payment_type', 'Platba:', $choicePayment)->setDefaultValue($data->payment_type)->setRequired('Zvol způsob platby.');
        
        $form->addSubmit('submit', 'Pokračovat k rekapitulaci objednávky');

        $form->onSuccess[] = $this->shippingPaymentFormSucceeded(...);

        return $form;
    }

    private function shippingPaymentFormSucceeded(array $data): void {
        
        $this->helper->getBasket()->update($data);
        
       
        $this->redirect('Home:');
    }
 
}

