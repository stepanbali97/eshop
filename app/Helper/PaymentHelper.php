<?php

declare (stict_types=1);

namespace App\Helper;

/**
 * Description of PaymentHelper
 *
 * @author stepanbalatka
 */
final class PaymentHelper {

    public function getPayment(): array {
        $choicePayment = [
            0 => 'Převodem na bankovní účet',
            1 => 'Kartou',
            2 => 'Kryptoměna DOGE',
        ];
        return $choicePayment;
    }

    public function getPaymentType(int $payment_type): string {
        $paymentType = $this->getPayment();
        
       if (array_key_exists($payment_type, $paymentType)) { 
            return $paymentType[$payment_type];
       } else {
            return 'Neznámý typ platby';
        }
    }
}
