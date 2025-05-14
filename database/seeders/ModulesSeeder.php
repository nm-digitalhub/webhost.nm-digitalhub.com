<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'name' => 'Product Management',
                'slug' => 'product',
                'description' => 'Manage products, categories, and inventory.',
                'icon' => 'heroicon-o-shopping-bag',
                'enabled' => true,
                'version' => '1.0',
                'meta' => [
                    'menu_position' => 10,
                    'requires' => [],
                    'tables' => ['products'],
                ],
            ],
            [
                'name' => 'Shopping Cart',
                'slug' => 'cart',
                'description' => 'Shopping cart functionality with product management.',
                'icon' => 'heroicon-o-shopping-cart',
                'enabled' => true,
                'version' => '1.0',
                'meta' => [
                    'menu_position' => 15,
                    'requires' => ['product'],
                    'tables' => ['carts', 'cart_items'],
                ],
            ],
            [
                'name' => 'Checkout',
                'slug' => 'checkout',
                'description' => 'Checkout process, payment integration and order processing.',
                'icon' => 'heroicon-o-credit-card',
                'enabled' => true,
                'version' => '1.0',
                'meta' => [
                    'menu_position' => 20,
                    'requires' => ['product', 'cart'],
                    'tables' => ['orders', 'order_items', 'transactions'],
                ],
            ],
            [
                'name' => 'Coupon Management',
                'slug' => 'coupon',
                'description' => 'Create and manage discount coupons.',
                'icon' => 'heroicon-o-receipt-percent',
                'enabled' => true,
                'version' => '1.0',
                'meta' => [
                    'menu_position' => 25,
                    'requires' => ['cart'],
                    'tables' => ['coupons'],
                ],
            ],
            [
                'name' => 'Page Editor',
                'slug' => 'page',
                'description' => 'Create and manage CMS pages with rich content editing.',
                'icon' => 'heroicon-o-document-text',
                'enabled' => true,
                'version' => '1.0',
                'meta' => [
                    'menu_position' => 30,
                    'requires' => [],
                    'tables' => ['pages'],
                ],
            ],
        ];

        foreach ($modules as $moduleData) {
            Module::updateOrCreate(
                ['slug' => $moduleData['slug']],
                $moduleData
            );
        }
    }
}
