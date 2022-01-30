<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use App\Services\ProductService;

class OrderController extends Controller
{

    private $repository;
    private $productRepository;
    private $service;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository, OrderService $orderService, ProductService $productService)
    {
        $this->repository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->service = $orderService;
        $this->productService = $productService;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $product = $this->productRepository->getById($request->product_id);
            if (!$product) {
                return response()->json(['message' => 'Unable to find product'], 400);
            }
            if ($request->quantity > $product->available_stock) {
                return response()->json(['message' => 'Failed to order this product due to unavailability of the stock'], 400);
            } else {
                $data = [
                    'product_name' => $product->name,
                    'quantity' => $request->quantity,
                ];
                $order =  $this->service->store($data);
                $this->productService->subStock($product, $order);
                return response()->json(['message' => 'You have successfully ordered this product.'], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage() ], 201);
        }
    }
}
