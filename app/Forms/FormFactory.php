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
}
