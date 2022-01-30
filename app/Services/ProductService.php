<?php

namespace App\Services;
use App\Models\Order;
use App\Models\Product;
use App\Services\BaseService;

class ProductService extends BaseService
{

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function subStock(Product $product, Order $order)
    {
        $product->available_stock = ($product->available_stock - $order->quantity);
        $product->save();

        return $product;
    }

}
