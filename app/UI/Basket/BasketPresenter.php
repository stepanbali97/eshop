<?php

declare (strict_types=1);

namespace App\UI\Basket;

use Nette\Http\Session;
use Nette\Application\UI\Presenter;

/**
 * Description of BasketPresenter
 *
 * @author stepanbalatka
 */
final class BasketPresenter extends Presenter
{
    private Session $session;

    public function __construct(Session $session)
    {
        parent::__construct();
        $this->session = $session;
    }

    public function renderDefault(): void
    {
        $order = $this->session->getSection('basket')->getData();
        $this->template->basket = $order;
    }
}

