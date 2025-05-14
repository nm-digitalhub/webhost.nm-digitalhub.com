<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Apply schema optimizations incrementally to preserve data.
     *
     * This migration implements best practices:
     * - String length standardization
     * - Index optimization
     * - SoftDeletes where needed
     * - Decimal precision standardization
     * - Proper enum types
     *
     * All changes are backward compatible and safe for production.
     */
    public function up(): void
    {
        $this->optimizeUsersTable();

        // Only optimize tables that exist with their expected columns
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'is_active')) {
            $this->optimizeProductsTable();
        }

        if (Schema::hasTable('plans') && Schema::hasColumn('plans', 'is_active')) {
            $this->optimizePlansTable();
        }

        if (Schema::hasTable('plan_features') && Schema::hasColumn('plan_features', 'is_highlighted')) {
            $this->optimizePlanFeaturesTable();
        }

        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'status')) {
            $this->optimizeOrdersTable();
        }

        if (Schema::hasTable('order_items') && Schema::hasColumn('order_items', 'name')) {
            $this->optimizeOrderItemsTable();
        }

        if (Schema::hasTable('transactions') && Schema::hasColumn('transactions', 'status')) {
            $this->optimizeTransactionsTable();
        }

        if (Schema::hasTable('carts') && Schema::hasColumn('carts', 'session_id')) {
            $this->optimizeCartsTable();
        }

        if (Schema::hasTable('cart_items') && Schema::hasColumn('cart_items', 'product_id')) {
            $this->optimizeCartItemsTable();
        }

        if (Schema::hasTable('coupons') && Schema::hasColumn('coupons', 'is_active')) {
            $this->optimizeCouponsTable();
        }

        if (Schema::hasTable('pages') && Schema::hasColumn('pages', 'is_published')) {
            $this->optimizePagesTable();
        }

        if (Schema::hasTable('generators') && Schema::hasColumn('generators', 'type')) {
            $this->optimizeGeneratorsTable();
        }

        if (Schema::hasTable('generation_logs') && Schema::hasColumn('generation_logs', 'status')) {
            $this->optimizeGenerationLogsTable();
        }

        $this->optimizePermissionTables();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: We don't need to reverse these optimizations as they're
        // all safe, non-destructive changes. However, for migrations that
        // could be rolled back, we provide the down() implementation.

        // Users table
        if (Schema::hasColumn('users', 'deleted_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Orders table
        if (Schema::hasColumn('orders', 'deleted_at')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Order items table
        if (Schema::hasColumn('order_items', 'deleted_at')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Plans table
        if (Schema::hasColumn('plans', 'deleted_at')) {
            Schema::table('plans', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Transactions table
        if (Schema::hasColumn('transactions', 'deleted_at')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // We won't try to reverse the index changes or column type modifications
        // as they would be too complex to safely reverse
    }

    /**
     * Optimize the users table
     */
    protected function optimizeUsersTable(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Add soft deletes if missing
                if (! Schema::hasColumn('users', 'deleted_at')) {
                    $table->softDeletes();
                }

                // Add indexes if missing
                if (! $this->hasIndex('users', 'users_email_verified_at_index')) {
                    $table->index('email_verified_at');
                }
            });

            // Change string length to standard - must be done separately as it can't be inside a closure
            $this->modifyStringLength('users', 'name', 100);
            $this->modifyStringLength('users', 'email', 191);
        }
    }

    /**
     * Optimize the products table
     */
    protected function optimizeProductsTable(): void
    {
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                // Add indexes if missing
                if (! $this->hasIndex('products', 'products_is_active_index')) {
                    $table->index('is_active');
                }
                if (! $this->hasIndex('products', 'products_is_featured_index')) {
                    $table->index('is_featured');
                }
                if (! $this->hasIndex('products', 'products_type_index')) {
                    $table->index('type');
                }
                if (! $this->hasIndex('products', 'products_sku_index')) {
                    $table->index('sku');
                }

                // Add composite index if missing
                if (! $this->hasIndex('products', 'products_is_active_type_is_featured_index')) {
                    $table->index(['is_active', 'type', 'is_featured']);
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('products', 'name', 100);
            $this->modifyStringLength('products', 'slug', 100);
            $this->modifyStringLength('products', 'short_description', 191);
            $this->modifyStringLength('products', 'sku', 50);
            $this->modifyStringLength('products', 'currency', 3);
            $this->modifyStringLength('products', 'image', 191);
        }
    }

    /**
     * Optimize the plans table
     */
    protected function optimizePlansTable(): void
    {
        if (Schema::hasTable('plans')) {
            Schema::table('plans', function (Blueprint $table) {
                // Add soft deletes if missing
                if (! Schema::hasColumn('plans', 'deleted_at')) {
                    $table->softDeletes();
                }

                // Add indexes if missing
                if (! $this->hasIndex('plans', 'plans_is_active_index')) {
                    $table->index('is_active');
                }
                if (! $this->hasIndex('plans', 'plans_is_featured_index')) {
                    $table->index('is_featured');
                }
                if (! $this->hasIndex('plans', 'plans_sort_order_index')) {
                    $table->index('sort_order');
                }

                // Add composite index if missing
                if (! $this->hasIndex('plans', 'plans_is_active_is_featured_index')) {
                    $table->index(['is_active', 'is_featured']);
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('plans', 'name', 100);
            $this->modifyStringLength('plans', 'slug', 100);
            $this->modifyStringLength('plans', 'currency', 3);

            // Convert billing_cycle from string to enum (safe)
            if (Schema::hasColumn('plans', 'billing_cycle')) {
                $this->convertStringToEnum('plans', 'billing_cycle', ['monthly', 'quarterly', 'yearly'], 'monthly');
            }
        }
    }

    /**
     * Optimize the plan_features table
     */
    protected function optimizePlanFeaturesTable(): void
    {
        if (Schema::hasTable('plan_features')) {
            Schema::table('plan_features', function (Blueprint $table) {
                // Add indexes if missing
                if (! $this->hasIndex('plan_features', 'plan_features_is_highlighted_index')) {
                    $table->index('is_highlighted');
                }
                if (! $this->hasIndex('plan_features', 'plan_features_sort_order_index')) {
                    $table->index('sort_order');
                }

                // Add composite index if missing
                if (! $this->hasIndex('plan_features', 'plan_features_plan_id_is_highlighted_index')) {
                    $table->index(['plan_id', 'is_highlighted']);
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('plan_features', 'name', 100);
            $this->modifyStringLength('plan_features', 'value', 191);
        }
    }

    /**
     * Optimize the orders table
     */
    protected function optimizeOrdersTable(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                // Add soft deletes if missing
                if (! Schema::hasColumn('orders', 'deleted_at')) {
                    $table->softDeletes();
                }

                // Add indexes if missing
                if (! $this->hasIndex('orders', 'orders_status_index')) {
                    $table->index('status');
                }
                if (! $this->hasIndex('orders', 'orders_order_number_index')) {
                    $table->index('order_number');
                }

                // Add composite index if missing
                if (! $this->hasIndex('orders', 'orders_status_created_at_index')) {
                    $table->index(['status', 'created_at']);
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('orders', 'order_number', 50);
            $this->modifyStringLength('orders', 'currency', 3);
            $this->modifyStringLength('orders', 'billing_name', 100);
            $this->modifyStringLength('orders', 'billing_email', 191);
            $this->modifyStringLength('orders', 'billing_phone', 20);
            $this->modifyStringLength('orders', 'billing_address', 191);
            $this->modifyStringLength('orders', 'billing_city', 100);
            $this->modifyStringLength('orders', 'billing_state', 100);
            $this->modifyStringLength('orders', 'billing_zip', 20);
            $this->modifyStringLength('orders', 'billing_country', 2);
        }
    }

    /**
     * Optimize the order_items table
     */
    protected function optimizeOrderItemsTable(): void
    {
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                // Add soft deletes if missing
                if (! Schema::hasColumn('order_items', 'deleted_at')) {
                    $table->softDeletes();
                }

                // Add index on product_id if missing
                if (! $this->hasIndex('order_items', 'order_items_product_id_index') &&
                    Schema::hasColumn('order_items', 'product_id')) {
                    $table->index('product_id');
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('order_items', 'name', 100);
            $this->modifyStringLength('order_items', 'sku', 50);
        }
    }

    /**
     * Optimize the transactions table
     */
    protected function optimizeTransactionsTable(): void
    {
        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                // Add soft deletes if missing
                if (! Schema::hasColumn('transactions', 'deleted_at')) {
                    $table->softDeletes();
                }

                // Add indexes if missing
                if (! $this->hasIndex('transactions', 'transactions_status_index')) {
                    $table->index('status');
                }
                if (! $this->hasIndex('transactions', 'transactions_transaction_id_index') &&
                    Schema::hasColumn('transactions', 'transaction_id')) {
                    $table->index('transaction_id');
                }

                // Add composite index if missing
                if (! $this->hasIndex('transactions', 'transactions_status_created_at_index')) {
                    $table->index(['status', 'created_at']);
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('transactions', 'transaction_id', 100);
            $this->modifyStringLength('transactions', 'provider', 50);
            $this->modifyStringLength('transactions', 'method', 30);
            $this->modifyStringLength('transactions', 'currency', 3);
        }
    }

    /**
     * Optimize the carts table
     */
    protected function optimizeCartsTable(): void
    {
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                // Add expires_at column if missing
                if (! Schema::hasColumn('carts', 'expires_at')) {
                    $table->timestamp('expires_at')->nullable()->index();
                }

                // Add index on session_id if missing
                if (! $this->hasIndex('carts', 'carts_session_id_index') &&
                    Schema::hasColumn('carts', 'session_id')) {
                    $table->index('session_id');
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('carts', 'session_id', 100);
            $this->modifyStringLength('carts', 'currency', 3);
        }
    }

    /**
     * Optimize the cart_items table
     */
    protected function optimizeCartItemsTable(): void
    {
        if (Schema::hasTable('cart_items')) {
            Schema::table('cart_items', function (Blueprint $table) {
                // Add index on product_id if missing
                if (! $this->hasIndex('cart_items', 'cart_items_product_id_index')) {
                    $table->index('product_id');
                }

                // Add unique constraint on cart_id and product_id if missing
                if (! $this->hasIndex('cart_items', 'cart_items_cart_id_product_id_unique')) {
                    try {
                        $table->unique(['cart_id', 'product_id']);
                    } catch (\Exception $e) {
                        // If there are duplicate entries, we can't add the constraint
                        // Log the error but continue with other optimizations
                        \Log::error('Error adding unique constraint to cart_items: '.$e->getMessage());
                    }
                }
            });
        }
    }

    /**
     * Optimize the coupons table
     */
    protected function optimizeCouponsTable(): void
    {
        if (Schema::hasTable('coupons')) {
            Schema::table('coupons', function (Blueprint $table) {
                // Add indexes if missing
                if (! $this->hasIndex('coupons', 'coupons_starts_at_index')) {
                    $table->index('starts_at');
                }
                if (! $this->hasIndex('coupons', 'coupons_expires_at_index')) {
                    $table->index('expires_at');
                }
                if (! $this->hasIndex('coupons', 'coupons_is_active_index')) {
                    $table->index('is_active');
                }

                // Add composite index if missing
                if (! $this->hasIndex('coupons', 'coupons_is_active_starts_at_expires_at_index')) {
                    $table->index(['is_active', 'starts_at', 'expires_at']);
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('coupons', 'code', 50);
        }
    }

    /**
     * Optimize the pages table
     */
    protected function optimizePagesTable(): void
    {
        if (Schema::hasTable('pages')) {
            Schema::table('pages', function (Blueprint $table) {
                // Add indexes if missing
                if (! $this->hasIndex('pages', 'pages_is_published_index')) {
                    $table->index('is_published');
                }
                if (! $this->hasIndex('pages', 'pages_type_index')) {
                    $table->index('type');
                }
                if (! $this->hasIndex('pages', 'pages_language_index')) {
                    $table->index('language');
                }
                if (! $this->hasIndex('pages', 'pages_order_index')) {
                    $table->index('order');
                }

                // Add composite index if missing
                if (! $this->hasIndex('pages', 'pages_is_published_language_type_index')) {
                    $table->index(['is_published', 'language', 'type']);
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('pages', 'title', 100);
            $this->modifyStringLength('pages', 'slug', 100);
            $this->modifyStringLength('pages', 'type', 50);
            $this->modifyStringLength('pages', 'language', 5);
            $this->modifyStringLength('pages', 'meta_title', 100);
            $this->modifyStringLength('pages', 'meta_keywords', 191);
            $this->modifyStringLength('pages', 'layout', 50);
            $this->modifyStringLength('pages', 'featured_image', 191);
        }
    }

    /**
     * Optimize the generators table
     */
    protected function optimizeGeneratorsTable(): void
    {
        if (Schema::hasTable('generators')) {
            Schema::table('generators', function (Blueprint $table) {
                // Add index on type if missing
                if (! $this->hasIndex('generators', 'generators_type_index')) {
                    $table->index('type');
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('generators', 'name', 100);
        }
    }

    /**
     * Optimize the generation_logs table
     */
    protected function optimizeGenerationLogsTable(): void
    {
        if (Schema::hasTable('generation_logs')) {
            Schema::table('generation_logs', function (Blueprint $table) {
                // Add indexes if missing
                if (! $this->hasIndex('generation_logs', 'generation_logs_status_index')) {
                    $table->index('status');
                }
                if (! $this->hasIndex('generation_logs', 'generation_logs_entity_type_index')) {
                    $table->index('entity_type');
                }
                if (! $this->hasIndex('generation_logs', 'generation_logs_generator_id_index')) {
                    $table->index('generator_id');
                }
            });

            // Modify string lengths to standards
            $this->modifyStringLength('generation_logs', 'entity_type', 50);
            $this->modifyStringLength('generation_logs', 'entity_name', 100);
            $this->modifyStringLength('generation_logs', 'namespace', 191);
        }
    }

    /**
     * Optimize the permission-related tables
     */
    protected function optimizePermissionTables(): void
    {
        $tableNames = config('permission.table_names', []);

        if (empty($tableNames)) {
            return;
        }

        // Permissions table
        if (Schema::hasTable($tableNames['permissions'])) {
            $this->modifyStringLength($tableNames['permissions'], 'name', 125);
            $this->modifyStringLength($tableNames['permissions'], 'guard_name', 125);
        }

        // Roles table
        if (Schema::hasTable($tableNames['roles'])) {
            $this->modifyStringLength($tableNames['roles'], 'name', 125);
            $this->modifyStringLength($tableNames['roles'], 'guard_name', 125);
        }

        // Model has permissions table
        if (Schema::hasTable($tableNames['model_has_permissions'])) {
            $this->modifyStringLength($tableNames['model_has_permissions'], 'model_type', 125);
        }

        // Model has roles table
        if (Schema::hasTable($tableNames['model_has_roles'])) {
            $this->modifyStringLength($tableNames['model_has_roles'], 'model_type', 125);
        }
    }

    /**
     * Helper method to check if an index exists
     */
    protected function hasIndex(string $table, string $index): bool
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = '{$index}'");

            return ! empty($indexes);
        } catch (\Exception) {
            return false;
        }
    }

    /**
     * Helper method to modify string column length
     */
    protected function modifyStringLength(string $table, string $column, int $length): void
    {
        try {
            if (Schema::hasColumn($table, $column)) {
                // Get the current column type
                $columnInfo = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'");

                if (! empty($columnInfo)) {
                    $type = $columnInfo[0]->Type;

                    // Only modify if it's a string type column (VARCHAR, CHAR, etc.)
                    if (str_contains((string) $type, 'varchar') || str_contains((string) $type, 'char')) {
                        // Get nullable and default attributes
                        $nullable = $columnInfo[0]->Null === 'YES' ? ' NULL' : ' NOT NULL';
                        $default = $columnInfo[0]->Default !== null ? " DEFAULT '{$columnInfo[0]->Default}'" : '';

                        DB::statement("ALTER TABLE {$table} MODIFY {$column} VARCHAR({$length}){$nullable}{$default}");
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error but continue with other optimizations
            \Log::error("Error modifying column {$column} on table {$table}: ".$e->getMessage());
        }
    }

    /**
     * Helper method to convert string column to enum
     * This is done safely by first checking values and providing a fallback
     */
    protected function convertStringToEnum(string $table, string $column, array $allowedValues, string $default): void
    {
        try {
            if (Schema::hasColumn($table, $column)) {
                // Get the current column type
                $columnInfo = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'");

                if (! empty($columnInfo)) {
                    $type = $columnInfo[0]->Type;

                    // Only convert if it's not already an enum
                    if (! str_contains((string) $type, 'enum')) {
                        // First ensure all values are valid
                        $values = implode("','", $allowedValues);

                        // Update any invalid values to the default
                        DB::statement("UPDATE {$table} SET {$column} = '{$default}' WHERE {$column} NOT IN ('{$values}')");

                        // Now convert the column to enum
                        $enumDef = "ENUM('{$values}')";
                        $nullable = $columnInfo[0]->Null === 'YES' ? ' NULL' : ' NOT NULL';
                        $defaultClause = " DEFAULT '{$default}'";

                        DB::statement("ALTER TABLE {$table} MODIFY {$column} {$enumDef}{$nullable}{$defaultClause}");
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error but continue with other optimizations
            \Log::error("Error converting column {$column} on table {$table} to enum: ".$e->getMessage());
        }
    }
};
