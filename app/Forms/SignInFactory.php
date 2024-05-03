<?php

declare (strict_types=1);

namespace App\Forms;

use App\Forms\FormFactory;
use Nette\Application\UI\Form;

/**
 * Description of SignInFactory
 *
 * @author stepanbalatka
 */
final class SignInFactory {

    public function __construct(
            private FormFactory $formFactory,
    ) {
        
    }

    public function create(): Form {
        $form = $this->formFactory->createForm();
        $form->addText('username', 'Jméno:')->setRequired('Zadejte své uživatelské jméno!');
        $form->addPassword('password', 'Heslo:')->setRequired('Zadejte své heslo!');
        $form->addSubmit('send', 'Přihlásit');

        return $form;
    }
}
