<?php

declare (strict_types=1);

namespace App\UI\Edit;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use App\Models\DbFacade;

/**
 * Description of EditPresenter
 *
 * @author stepanbalatka
 */
final class EditPresenter extends Presenter 
{
    private int $productId;

    public function __construct(
            private DbFacade $facade,
    ) {
        
    }
    
    protected function createComponentEditProductForm(): Form 
    {
        $form = new Form;
        $form->addText('name', 'Název produktu:')->setRequired();
        $form->addText('short_description', 'Krátký popis:')->setRequired();
        $form->addTextArea('description', 'Celý popis:')->setRequired();
        $form->addText('price_doge', 'Prodejní cena:')->setRequired()->addRule(Form::Integer, 'Prodejní cena musí být celé číslo');
        $form->addText('last_price_doge', 'Původní prodejní cena:')->setRequired()->addRule(Form::Integer, 'Prodejní cena musí být celé číslo');
        $form->addSubmit('submit', 'Editovat');
        
        $form->onSuccess[] = $this->processEditProductForm(...);
        
        return $form;
    }
    
    public function actionDefault(int $id): void 
    {
        $this->productId = $id;
        $product = $this->facade->getProduct($id);
        if (!$product) {
            $this->error('Produkt nebyl nalezen.');
        }
        $this['editProductForm']->setDefaults([
           'name' => $product->name,
           'short_description' => $product->short_description,
           'description' => $product->description,
           'last_price_doge' => $product->last_price_doge,
           'price_doge' => $product->price_doge,
        ]);
    }
    
    
    private function processEditProductForm(Form $form, array $data): void 
    {
        $this->facade->editProduct($this->productId, $data['name'], $data['short_description'], $data['description'], $data['price_doge'], $data['last_price_doge']);
        
        $this->flashMessage('Produkt byl úspěšně změněn.');
        $this->redirect('Home:');
    }
}
