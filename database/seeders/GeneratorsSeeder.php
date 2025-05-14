<?php

namespace Database\Seeders;

use App\Models\Generator;
use Illuminate\Database\Seeder;

class GeneratorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // We'll use DB facade to handle foreign key constraints properly
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Generator::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Example fields for a User model
        $userFields = [
            ['name' => 'name', 'type' => 'string', 'required' => true, 'description' => 'The user\'s name'],
            ['name' => 'email', 'type' => 'string', 'required' => true, 'description' => 'The user\'s email address'],
            ['name' => 'password', 'type' => 'string', 'required' => true, 'description' => 'The user\'s password'],
            ['name' => 'profile_photo_path', 'type' => 'string', 'required' => false, 'description' => 'Path to profile photo'],
            ['name' => 'is_admin', 'type' => 'boolean', 'required' => false, 'description' => 'Admin status flag'],
        ];

        // Example relations for a User model
        $userRelations = [
            ['type' => 'hasMany', 'model' => 'App\\Models\\Post', 'foreignKey' => 'user_id', 'localKey' => 'id', 'description' => 'User\'s posts'],
            ['type' => 'hasOne', 'model' => 'App\\Models\\Profile', 'foreignKey' => 'user_id', 'localKey' => 'id', 'description' => 'User\'s profile'],
        ];

        // Create a User model generator
        Generator::create([
            'name' => 'User',
            'type' => 'model',
            'description' => 'User model for authentication and profile management',
            'namespace' => 'App\\Models',
            'extends' => \Illuminate\Foundation\Auth\User::class,
            'implements' => \Illuminate\Contracts\Auth\MustVerifyEmail::class,
            'traits' => 'Illuminate\\Notifications\\Notifiable,Laravel\\Sanctum\\HasApiTokens',
            'fillable' => true,
            'fields' => $userFields,
            'timestamps' => true,
            'soft_deletes' => true,
            'relations' => $userRelations,
            'group' => 'Authentication',
            'icon' => 'heroicon-o-user',
            'label' => 'Users',
            'preview_before_generate' => true,
            'confirm_overwrite' => true,
            'target_path' => 'app/Models/User.php',
        ]);

        // Example fields for a Post model
        $postFields = [
            ['name' => 'title', 'type' => 'string', 'required' => true, 'description' => 'Post title'],
            ['name' => 'content', 'type' => 'text', 'required' => true, 'description' => 'Post content'],
            ['name' => 'published_at', 'type' => 'timestamp', 'required' => false, 'description' => 'Publication date'],
            ['name' => 'user_id', 'type' => 'foreignId', 'required' => true, 'description' => 'Author of the post'],
        ];

        // Example relations for a Post model
        $postRelations = [
            ['type' => 'belongsTo', 'model' => \App\Models\User::class, 'foreignKey' => 'user_id', 'localKey' => 'id', 'description' => 'Post author'],
            ['type' => 'hasMany', 'model' => 'App\\Models\\Comment', 'foreignKey' => 'post_id', 'localKey' => 'id', 'description' => 'Post comments'],
        ];

        // Create a Post model generator
        Generator::create([
            'name' => 'Post',
            'type' => 'model',
            'description' => 'Blog post model for content management',
            'namespace' => 'App\\Models',
            'extends' => \Illuminate\Database\Eloquent\Model::class,
            'implements' => '',
            'traits' => \Illuminate\Database\Eloquent\SoftDeletes::class,
            'fillable' => true,
            'fields' => $postFields,
            'timestamps' => true,
            'soft_deletes' => true,
            'relations' => $postRelations,
            'group' => 'Content',
            'icon' => 'heroicon-o-document-text',
            'label' => 'Posts',
            'preview_before_generate' => true,
            'confirm_overwrite' => true,
            'target_path' => 'app/Models/Post.php',
        ]);

        // Example fields for a Product model
        $productFields = [
            ['name' => 'name', 'type' => 'string', 'required' => true, 'description' => 'Product name'],
            ['name' => 'description', 'type' => 'text', 'required' => false, 'description' => 'Product description'],
            ['name' => 'price', 'type' => 'decimal', 'required' => true, 'description' => 'Product price'],
            ['name' => 'stock', 'type' => 'integer', 'required' => true, 'description' => 'Available stock'],
            ['name' => 'category_id', 'type' => 'foreignId', 'required' => true, 'description' => 'Product category'],
        ];

        // Create a Product model generator
        Generator::create([
            'name' => 'Product',
            'type' => 'model',
            'description' => 'Product model for e-commerce functionality',
            'namespace' => 'App\\Models',
            'extends' => \Illuminate\Database\Eloquent\Model::class,
            'implements' => '',
            'traits' => '',
            'fillable' => true,
            'fields' => $productFields,
            'timestamps' => true,
            'soft_deletes' => false,
            'relations' => [
                ['type' => 'belongsTo', 'model' => 'App\\Models\\Category', 'foreignKey' => 'category_id', 'localKey' => 'id', 'description' => 'Product category'],
            ],
            'group' => 'Commerce',
            'icon' => 'heroicon-o-shopping-bag',
            'label' => 'Products',
            'preview_before_generate' => true,
            'confirm_overwrite' => true,
            'target_path' => 'app/Models/Product.php',
        ]);

        // Example resource generator
        Generator::create([
            'name' => 'UserResource',
            'type' => 'resource',
            'description' => 'Admin panel resource for managing users',
            'namespace' => 'App\\Filament\\Resources',
            'extends' => \Filament\Resources\Resource::class,
            'implements' => '',
            'traits' => '',
            'fillable' => false,
            'timestamps' => false,
            'fields' => [
                ['name' => 'name', 'type' => 'TextInput', 'required' => true],
                ['name' => 'email', 'type' => 'TextInput', 'required' => true],
                ['name' => 'is_admin', 'type' => 'Toggle', 'required' => false],
            ],
            'group' => 'Administration',
            'icon' => 'heroicon-o-users',
            'label' => 'User Management',
            'preview_before_generate' => true,
            'confirm_overwrite' => true,
            'target_path' => 'app/Filament/Resources/UserResource.php',
        ]);

        // Example page generator
        Generator::create([
            'name' => 'SettingsPage',
            'type' => 'page',
            'description' => 'Admin settings configuration page',
            'namespace' => 'App\\Filament\\Pages',
            'extends' => \Filament\Pages\Page::class,
            'implements' => '',
            'traits' => \Filament\Pages\Concerns\InteractsWithFormActions::class,
            'fields' => [
                ['name' => 'site_name', 'type' => 'TextInput', 'required' => true],
                ['name' => 'site_description', 'type' => 'Textarea', 'required' => false],
                ['name' => 'maintenance_mode', 'type' => 'Toggle', 'required' => false],
            ],
            'group' => 'System',
            'icon' => 'heroicon-o-cog',
            'label' => 'Site Settings',
            'preview_before_generate' => true,
            'confirm_overwrite' => true,
            'target_path' => 'app/Filament/Pages/Settings.php',
        ]);

        // Example widget generator
        Generator::create([
            'name' => 'StatsOverviewWidget',
            'type' => 'widget',
            'description' => 'Dashboard widget showing key statistics',
            'namespace' => 'App\\Filament\\Widgets',
            'extends' => \Filament\Widgets\StatsOverviewWidget::class,
            'implements' => '',
            'traits' => '',
            'group' => 'Dashboard',
            'icon' => 'heroicon-o-chart-bar',
            'label' => 'Stats Overview',
            'preview_before_generate' => true,
            'confirm_overwrite' => true,
            'target_path' => 'app/Filament/Widgets/StatsOverviewWidget.php',
        ]);
    }
}
