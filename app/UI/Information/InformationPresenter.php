<?php

declare (strict_types=1);

namespace App\UI\Information;

use \Nette\Application\UI\Presenter;
use \Nette\Application\UI\Form;
use \App\Models\DbFacade;
use \App\Helper\BasketHelper;

/**
 * Description of InformationPresenter
 *
 * @author stepanbalatka
 */
final class InformationPresenter extends Presenter
{
    public function __construct(
            private DbFacade $facade,
            private BasketHelper $helper,
    ) {
        
    }

    protected function createComponentInformationForm(): Form {
        $data = $this->helper->getBasket();
        
        $form = new Form;
        //hidden(id)
        $form->addText('addressee_name', 'Jméno a příjmení:')->setDefaultValue($data->addressee_name)->setRequired('Zadej své jméno.');
        $form->addText('address', 'Adresa č. p.:')->setDefaultValue($data->address)->setRequired('Zadej adresu.');
        $form->addText('city', 'Město:')->setDefaultValue($data->city)->setRequired('Zadej název města.');
        $form->addText('postcode', 'PSČ:')->setDefaultValue($data->postcode)->setRequired('Zadej PSČ.');
        $form->addEmail('email', 'E-mail:')->setDefaultValue($data->email)->setRequired('Zadejte platnou e-mailovou adresu.')->addRule(Form::Email);
        $form->addText('phone', 'Telefonní číslo:')->setDefaultValue($data->phone)->setRequired('Zadej telefoní číslo.');
        
        $form->addSubmit('submit', 'Pokračovat na způsob dopravy a platby');

        $form->onSuccess[] = $this->informationFormSucceeded(...);

        return $form;
    }

    private function informationFormSucceeded(array $data): void {
        
        $order = $this->helper->getBasket();

        if ($order) {
            $order->update($data);
        } else {
            $this->flashMessage("Nebyl vybrán žádný produkt. Vyber produkt a vlož jej do košíku.");
        }
       
        $this->redirect('Home:');
    }
 
}
