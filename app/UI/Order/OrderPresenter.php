<?php

declare (strict_types=1);

namespace App\UI\Order;

use Nette\Application\UI\Presenter;
use App\Models\DbFacade;

/**
 * Description of OrderPresenter
 *
 * @author stepanbalatka
 */
final class OrderPresenter extends Presenter 
{
      public function __construct(
            private DbFacade $facade,
    ) {
        
    } 
    
    
}
