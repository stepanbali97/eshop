<?php

declare (strict_types=1);

namespace app\UI\Rekapitulation;

use \Nette\Application\UI\Presenter;
use App\Models\DbFacade;
use App\Helper\BasketHelper;
use App\Helper\PaymentHelper;
use \App\Helper\ShippingHelper;

/**
 * Description of RekapitulationPresenter
 *
 * @author stepanbalatka
 */
final class RekapitulationPresenter extends Presenter {

    public function __construct(
            private DbFacade $facade,
            private BasketHelper $helper,
            private PaymentHelper $payment,
            private ShippingHelper $shipping,
    ) {
        
    }

    public function renderDefault(): void {
        $basket = $this->helper->getBasket();

        //pro košík vytáhnu a připravím všechny položky
        $basketItems = $this->facade->getBasketItems($basket->id);
        $this->template->basketItems = $basketItems;

        $shippingType = $basket->shipping_type;
        $selectedShippingType = $this->shipping->getShippingType($shippingType);
        $this->template->shippingType = $selectedShippingType;
        
        $paymentType = $basket->payment_type;
        $selectedPaymentType = $this->payment->getPaymentType($paymentType);
        $this->template->paymentType = $selectedPaymentType;

        $totalSum = 0;
        foreach ($basketItems as $itemPrice) {
            $totalSum += $itemPrice->price;
        }
        $this->template->totalSum = $totalSum;
    }
}
