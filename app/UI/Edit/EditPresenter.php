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
final class EditPresenter extends Presenter 
{
    public function __construct(
            private DbFacade $facade,
    ) {
        
    }
    
    protected function createComponentAddProductForm(): Form
    {
        $form = new Form;
        $form->addText('name', 'Název produktu:')->setRequired();
        $form->addText('short_description', 'Krátký popis:')->setRequired();
        $form->addTextArea('description', 'Celý popis:')->setRequired();
        $form->addText('price_doge', 'Prodejní cena:')->setRequired()->addRule(Form::Integer, 'Prodejní cena musí být celé číslo');
        $form->addMultiUpload('images', 'Obrázky')->setHtmlAttribute('accept', 'images/*')->setRequired(false)->addRule(Form::IMAGE, 'Tento formát obrázku není podporován, vyber jiný');
        $form->addSubmit('send', 'Uložit do databáze');
        
        $form->onSuccess[] = $this->addProductFormSucceeded(...);
        
        return $form;
    }
    
    private function addProductFormSucceeded(Form $form, array $data): void 
    {
        $this->facade->addProduct($data['name'], $data['short_description'], $data['description'], $data['price_doge']);
        
        $this->flashMessage("Produkt byl úspěšně přidán.", 'success');
        $this->redirect('Home:');
    }
}

    
