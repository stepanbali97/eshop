<?php

declare (strict_types=1);

namespace App\UI\Sign;

use Nette;
use Nette\Application\UI\Form;

/**
 * Description of SignPresenter
 *
 * @author stepanbalatka
 */
final class SignPresenter extends Nette\Application\UI\Presenter {

    protected function createComponentSignInForm(): Form {
        $form = new Form;
        $form->addText('username', 'Jméno:')->setRequired('Zadejte své uživatelské jméno!');
        $form->addPassword('password', 'Heslo:')->setRequired('Zadejte své heslo!');
        $form->addSubmit('send', 'Přihlásit');
        
        $form->onSuccess[] = $this->signInFormSucceeded(...);
        return $form;
    }
    
    private function signInFormSucceeded(Form $form, \stdClass $values): void 
    {
        try {
            $this->getUser()->login($values->username, $values->password);
            $this->redirect('Home:');

        } catch (Nette\Security\AuthenticationException $e) {
                $form->addError('Přihlašovací jméno nebo heslo není správné.');
            }
    }

    public function actionOut(): void {
        $this->getUser()->logout();
        $this->flashMessage('Odhlášení bylo úspěšné.');
        $this->redirect('Home:');
    }
}