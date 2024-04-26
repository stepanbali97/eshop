<?php

declare (strict_types=1);

namespace App\Models;

use Nette;

/**
 * Description of HomeManager
 *
 * @author stepanbalatka
 */
final class DbFacade {

    public function __construct(
            private Nette\Database\Explorer $database,
    ) {
        
    }

    //tohle správně?
    public function addProduct(string $name, string $short_description, string $description, int $price_doge) {
        $newProduct = $this->database->table('products')->insert([
            'name' => $name,
            'short_description' => $short_description,
            'description' => $description,
            'price_doge' => $price_doge,
        ]);
        return $newProduct;
    }

    public function editProduct(int $id, string $name, string $short_description, string $description, int $last_price_doge, int $price_doge) {
        $this->database->table('products')->where('id', $id)->update([
            'name' => $name,
            'short_description' => $short_description,
            'description' => $description,
            'last_price_doge' => $last_price_doge,
            'price_doge' => $price_doge,
        ]);
    }

    public function createBasket() {
        $newRow = $this->database->table('order')->insert([
            'price' => 0,
            'status' => 0,
            'addressee_name' => '',
            'address' => '',
            'city' => '',
            'postcode' => 0,
            'email' => '',
            'phone' => '',
            'payment_type' => 0,
            'shipping_type' => 0,
            'ordered' => date('Y-m-d H:i:s'),
        ]);
        return $newRow;
    }

    public function getProduct(int $id): ?\Nette\Database\Table\ActiveRow {
        return $this->database->table('products')->get($id);
    }

    public function getBasket(int $id): ?\Nette\Database\Table\ActiveRow {
        return $this->database->table('order')->where('status', 0)->get($id);
    }

    public function getAllProducts() {
        return $this->database->table('products')->order('name')->fetchAll();
    }

    public function getProductById($productId) {
        return $this->database->table('products')->get($productId);
    }

    //vyberu podle id košíku z order_item 
    public function getBasketItems(int $basketId) {
        return $this->database->table('order_item')->where('order_id', $basketId)->fetchAll();
    }
}
