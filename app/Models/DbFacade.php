<?php

declare (strict_types=1);

namespace App\Models;

use Nette;

/**
 * Description of HomeManager
 *
 * @author stepanbalatka
 */
final class DbFacade 
{
    
    public function __construct(
            private Nette\Database\Explorer $database,
            ) {
    }
    
    public function addProduct(string $name, string $short_description, string $description, int $price_doge) 
    {
        $this->database->table('products')->insert([
           'name' => $name,
           'short_description' => $short_description,
           'description' => $description,
           'price_doge' => $price_doge, 
        ]);
    }
    
    public function editProduct(int $id, string $name, string $short_description, string $description, int $last_price_doge, int $price_doge) 
    {
        $this->database->table('products')->where('id', $id)->update([
           'name' => $name,
           'short_description' => $short_description,
           'description' => $description,
           'last_price_doge' => $last_price_doge,
           'price_doge' => $price_doge, 
        ]);
    }
    /*
    public function addToOrder(int $products_id, int $order_id, string $name, int $count, int $price)
    {
        
        $this->database->table('order_item')->insert([
            'products_id' => $products_id,
            'order_id' => $order_id,
            'name' => $name,
            'count' => $count = 1,
            'price' => $price,
        ]);
    }
    
     public function showOrder()
    {
        return $this->database->table('order_item')->();
    }
    */
    public function getProduct(int $id): ?\Nette\Database\Table\ActiveRow 
    {
        return $this->database->table('products')->get($id);
    }


    public function getAllProducts()
    {
        return $this->database->table('products')->fetchAll();
    }
    
    public function getProductById($productId)
    {
        return $this->database->table('products')->get($productId);
    }
}
