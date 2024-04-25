<?php

declare (strict_types=1);

namespace App\UI\Basket;

use Nette\Application\UI\Multiplier;
use Nette\Http\Session;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;

/**
 * Description of BasketPresenter
 *
 * @author stepanbalatka
 */
final class OrderPresenter extends Presenter
{
    private Session $session;
    
    public function __construct(Session $session) 
    {
        parent::__construct();
        $this->session = $session;
    }
    protected function createComponentAddProductToOrderForm(): Multiplier 
    {
        return new Multiplier(function ($itemId, $itemName) {
                    $form = new Nette\Application\UI\Form;
                    $form->addHidden('product_id', $itemId);
                    $form->addHidden('name', $itemName);
                    $form->addSubmit('send', 'Přidat do košíku');
                    $form->onSuccess[] = $this-> addProductToOrderFormSubmitted(...);
                    return $form;
                });
    }
    
    public function addProductToOrderFormSubmitted(Form $form, $values): void 
    {
        $productId = $values['product_id'];
        $productName = $values['name'];
        $basketId = uniqid('basket');
        
        $order = $this->session->getSection('order')->getData();
        
        $order[$productId] = $order[$productId] ?? ['name' => $productName, 'quantity' => 0];
        $order[$productId]['quantity']++;
        
        $this->session->getSection('order')->setData($order);
        
        $this->session->getSection('basket')->basketId = $basketId;
        
        $this->redirect('this:');
    }
    
    public function renderDefault(): void
    {
        $basketId = $this->session->getSection('basket')->basketId ?? null;
        $order = $this->session->getSection('order')->getData();
        
        $basket = [];
        foreach ($order as $productId => $item) {
            $basket[] = [
                'product_id' => $productId,
                'name' => $item['name'],
                'quantity' => $item['quantity']
            ];
        }

        $this->template->basket = $basket;
        $this->template->basketId = $basketId;
    }
}
