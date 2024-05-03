<?php

declare (strict_types=1);

namespace App\UI\Edit;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use App\Models\DbFacade;
use App\Forms\EditProductFormFactory;

/**
 * Description of EditPresenter
 *
 * @author stepanbalatka
 */
final class EditPresenter extends Presenter {

    public function __construct(
// private \Nette\Database\Explorer $database,
            private DbFacade $facade,
            private EditProductFormFactory $formFactory,
    ) {
        
    }

    protected function createComponentEditProductForm(): Form {
        $form = $this->formFactory->create();
        $form->onSuccess[] = function () { // use ($this)
            $this->flashMessage("Produkt byl úspěšně přidán.", 'success');
            $this->redirect('Home:');
        };
        return $form;
    }

    public function renderEdit(int $productId): void {
        $product = $this->facade->getProduct($productId);
// $product = $this->database->table('products')->get($productId);

        if (!$product) {
            $this->error('Product nebyl nalezen');
        }

        $this->getComponent('editProductForm')->setDefaults($product->toArray()); //pozor v doctrine by nemuselo fungovat
    }
}
