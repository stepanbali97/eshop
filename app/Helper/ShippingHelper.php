<?php

declare (stict_types=1);

namespace App\Helper;

/**
 * Description of ShippingHelper
 *
 * @author stepanbalatka
 */
final class ShippingHelper {

    public function getShipping(): array {
        $choiceShipping = [
            0 => 'Česká pošta',
            1 => 'Osobní odběr',
            2 => 'DPD',
            3 => 'Zásilkovna',
        ];
        return $choiceShipping;
    }

    public function getShippingType(int $shipping_type): string {
        $shippingType = $this->getShipping();

        if (array_key_exists($shipping_type, $shippingType)) {
            return $shippingType[$shipping_type];
        } else {
            return 'Neznámý způsob dopravy';
        }
    }
}
