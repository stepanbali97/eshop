<?php

declare (strict_types=1);

namespace App\Forms;

use Nette\Application\UI\Form;

/**
 * Description of FormFactory
 *
 * @author stepanbalatka
 */
class FormFactory 
{
    public function createForm(): Form
	{
		$form = new Form;
		return $form;
	}
        
        
        
        
        
        
        
        
        public function createEditForm(): Form
	{
		$form = $this->createForm();
		$form->addText('title', 'Titulek:');
		// zde se přidávají další formulářová pole
		$form->addSubmit('send', 'Odeslat');
		return $form;
	}

}
