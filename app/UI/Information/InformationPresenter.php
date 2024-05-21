<?php

declare (strict_types=1);

namespace app\UI\Information;

use \Nette\Application\UI\Presenter;
use \Nette\Application\UI\Form;
use App\Forms\InformationFormFactory;
use App\Helper\BasketHelper;

/**
 * Description of InformationPresenter
 *
 * @author stepanbalatka
 */
final class InformationPresenter extends Presenter {

    public function __construct(
            private InformationFormFactory $formFactory,
            private BasketHelper $helper,
    ) {
        
    }

    protected function createComponentInformationForm(): Form {
        $form = $this->formFactory->create();
        
        $form->onSuccess[] = $this->informationFormSucceeded(...);

        return $form;
       // $form->onSuccess[] = function () {
      //      $this->redirect('ShippingPayment:');
       // };
       // return $form;
    }
    
    public function informationFormSucceeded(array $data): void {

        $order = $this->helper->getBasket();

        
        if ($order) {
            $order->update($data); //mělo by být ve facade
            $this->redirect('ShippingPayment:');
        } else { //tohle je nesmysl, ošetřit jinde
            $this->flashMessage("Nebyl vybrán žádný produkt. Vyber produkt a vlož jej do košíku."); // musí pryč jinak spadne na držku
        }
    }
}
