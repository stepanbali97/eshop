<?php

declare (strict_types=1);

namespace App\UI\Edit;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;



/**
 * Description of EditPresenter
 *
 * @author stepanbalatka
 */
final class EditPresenter extends Presenter 
{
    public function __construct(
            private \Nette\Database\Explorer $database,
            private \App\Models\DbFacade $db,
    ) {
        
    }
    
    protected function createComponentProductForm(): Form
    {
        $form = new Form;
        $form->addText('name', 'Název produktu:')->setRequired();
        $form->addText('short_description', 'Krátký popis:')->setRequired();
        $form->addTextArea('description', 'Celý popis:')->setRequired();
        $form->addText('price_doge', 'Prodejní cena:')->setRequired()->addRule(Form::Integer, 'Prodejní cena musí být celé číslo');
        $form->addSubmit('send', 'Uložit a zveřejnit');
        
        $form->onSuccess[] = $this->productFormSucceeded(...);
        
        return $form;
    }
    
    private function productFormSucceeded(array $data): void 
    {
        $productId = (int)($this->getParameter('productId'));
        //$name = (string)($this->getParameter('name'));
        //$short_description = (string)($this->getParameter('short_description'));
        //$description = (string)($this->getParameter('description'));
        //$price_doge = (int)($this->getParameter('price_doge'));
        
        if ($productId) {
            $product = $this->db->getProduct($productId);
            //$product = $this->database->table('products')->get($productId);
            $product->update($data);
        } else {
            //$product = $this->db->addProduct($name, $short_description, $description, $price_doge);
             $product = $this->database->table('products')->insert($data);
        }
        
        $this->flashMessage("Produkt byl úspěšně přidán.", 'success');
        $this->redirect('Home:');
    }
    
    public function renderEdit(int $productId):void 
    {
        $product = $this->db->getProduct($productId);
        // $product = $this->database->table('products')->get($productId);
        
        if (!$product) {
            $this->error('Product nebyl nalezen');
        }
        
        $this->getComponent('productForm')->setDefaults($product->toArray());
    }
}

    
