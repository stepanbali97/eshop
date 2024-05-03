<?php

declare (strict_types=1);

namespace App\UI\Sign;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use App\Forms\SignInFactory;

/**
 * Description of SignPresenter
 *
 * @author stepanbalatka
 */
final class SignPresenter extends Presenter {

    public function __construct(
            private SignInFactory $formFactory,
    ) {
        
    }

    protected function createComponentSignInForm(): Form {
        $form = $this->formFactory->create();

        $form->onSuccess[] = $this->signInFormSucceeded(...);
        return $form;
    }

    private function signInFormSucceeded(Form $form, \stdClass $values): void {
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
