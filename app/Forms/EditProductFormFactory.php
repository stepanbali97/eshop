<?php

declare (strict_types=1);

namespace App\Forms;

use App\Models\DbFacade;
use App\Forms\FormFactory;
use Nette\Application\UI\Form;

/**
 * Description of EditProductFormFactory
 *
 * @author stepanbalatka
 */
final class EditProductFormFactory {

    public function __construct(
            private FormFactory $formFactory,
            private DbFacade $facade,
    ) {
        
    }

    public function create(?int $productId): Form {
        $form = $this->formFactory->createForm();
        $form->addText('name', 'Název produktu:')->setRequired();
        $form->addText('short_description', 'Krátký popis:')->setRequired();
        $form->addTextArea('description', 'Celý popis:')->setRequired();
        $form->addText('price_doge', 'Prodejní cena:')->setRequired()->addRule(Form::Integer, 'Prodejní cena musí být celé číslo');
        $form->addHidden('id', $productId);
        $form->addSubmit('send', 'Uložit a zveřejnit');

        //$form->onSuccess[] = $this->productFormSucceeded(...);

        return $form;
    }

    public function productFormSucceeded(array $data): void {
        $productId = (int) ($data['id']);
        // $productId = (int) ($this->getParameter('productId'));

        if ($productId) {
            $product = $this->facade->getProduct($productId);
            //$product = $this->database->table('products')->get($productId);
            $product->update([
                'name' => $data['name'],
                'short_description' => $data['short_description'],
                'description' => $data['description'],
                'price_doge' => $data['price_doge'],
            ]);
        } else {
            $product = $this->facade->addProduct(
                    $data['name'],
                    $data['short_description'],
                    $data['description'],
                    $data['price_doge'],
            );

            // $product = $this->database->table('products')->insert($data);
        }
    }
}
