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
    
    public function getAllProducts()
    {
        return $this->database->table('products')->fetchAll();
    }
    
    public function getProductById($productId)
    {
        return $this->database->table('products')->get($productId);
    }
}
