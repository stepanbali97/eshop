<?php

declare (stict_types=1);

namespace App\Helper;

use App\Models\DbFacade;

/**
 * Description of BasketHelper
 *
 * @author stepanbalatka
 */
final class BasketHelper 
{
     public function __construct(
            private DbFacade $facade,
    ) {
        
    }
    
    public function getBasket() {
        if (array_key_exists('basket_id', $_SESSION)) {
            $basketId = $_SESSION['basket_id'];
            $basket = $this->facade->getBasket($basketId);

            if ($basket === null) { //ošetřit zda opravdu existuje id košíku
                $basket = $this->facade->createBasket();
                $_SESSION['basket_id'] = $basket->id;
            }
        } else {
            $basket = $this->facade->createBasket();
            $_SESSION['basket_id'] = $basket->id;
        }
        return $basket;
    }
}
