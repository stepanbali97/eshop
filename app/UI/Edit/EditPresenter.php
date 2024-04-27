<?php

declare (strict_types=1);

namespace App\UI\Edit;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use App\Models\DbFacade;


/**
 * Description of EditPresenter
 *
 * @author stepanbalatka
 */
final class EditPresenter extends Presenter {

    public function __construct(
            // private \Nette\Database\Explorer $database,
            private DbFacade $facade,
    ) {
        
    }

    protected function createComponentProductForm(): Form {
        $form = new Form;
        $form->addText('name', 'Název produktu:')->setRequired();
        $form->addText('short_description', 'Krátký popis:')->setRequired();
        $form->addTextArea('description', 'Celý popis:')->setRequired();
        $form->addText('price_doge', 'Prodejní cena:')->setRequired()->addRule(Form::Integer, 'Prodejní cena musí být celé číslo');
        $form->addSubmit('send', 'Uložit a zveřejnit');

        $form->onSuccess[] = $this->productFormSucceeded(...);

        return $form;
    }

    private function productFormSucceeded(array $data): void {
        $productId = (int) ($this->getParameter('productId'));

        if ($productId) {
            $product = $this->facade->getProduct($productId);
            //$product = $this->database->table('products')->get($productId);
            $product->update($data);
        } else {
            $product = $this->facade->addProduct(
                    $data['name'],
                    $data['short_description'],
                    $data['description'],
                    $data['price_doge'],
            );
            // $product = $this->database->table('products')->insert($data);
        }

        $this->flashMessage("Produkt byl úspěšně přidán.", 'success');
        $this->redirect('Home:');
    }

    public function renderEdit(int $productId): void {
        $product = $this->facade->getProduct($productId);
        // $product = $this->database->table('products')->get($productId);

        if (!$product) {
            $this->error('Product nebyl nalezen');
        }

        $this->getComponent('productForm')->setDefaults($product->toArray());
    }
}
