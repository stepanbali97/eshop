<?php

declare(strict_types=1);

namespace App\UI;

use App\Forms\FormFactory;
use Nette\Application\AbortException;
use Nette\Application\UI\Presenter;

/**
 * Description of BasePresenter
 *
 * @author stepanbalatka
 */
abstract class BasePresenter extends Presenter
{
    const MSG_SUCCESS = 'success';
    
    const MSG_ERROR = 'danger';
    
    const MSG_INFO = 'info';
    
    protected FormFactory $formFactory;
    
    public final function injectFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }
    
    protected function startup() 
    {
        parent::startup();
        if (!$this->getUser()->isAllowed($this->getName(), $this->getAction())) {
            $this->flashMessage('Nejsi administrátor e-shopu.');
            $this->redirect(':Home');
        }
    }
    
    /* 
     * protected function beforeRender() 
    {
        parent::beforeRender();
        $this->template->admin = $this->getUser()->isInRole('admin');
    }
     */
}
