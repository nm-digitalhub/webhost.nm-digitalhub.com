# Filament PHPDoc Templates

## ListRecords Page Template

```php
<?php

namespace App\Filament\Resources\YourResourceName\Pages;

use App\Filament\Resources\YourResourceName;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;

/**
 * List YourModelName Records
 * 
 * This page displays a table of YourModelName records with filtering, sorting,
 * and bulk actions.
 */
class ListYourModelNames extends ListRecords
{
    protected static string $resource = YourResourceName::class;
    
    /**
     * The currently active tab
     * Matches parent class property type (?string)
     */
    #[Url]
    public ?string $activeTab = null;
    
    /**
     * Get the header actions for this page
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
```

## CreateRecord Page Template

```php
<?php

namespace App\Filament\Resources\YourResourceName\Pages;

use App\Filament\Resources\YourResourceName;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

/**
 * Create YourModelName Record
 * 
 * This page provides a form to create a new YourModelName record.
 */
class CreateYourModelName extends CreateRecord
{
    protected static string $resource = YourResourceName::class;
    
    /**
     * Handle successful record creation
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    /**
     * Create a notification after record creation
     */
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('YourModelName created')
            ->success()
            ->send();
    }
}
```

## EditRecord Page Template

```php
<?php

namespace App\Filament\Resources\YourResourceName\Pages;

use App\Filament\Resources\YourResourceName;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\Computed;
use Filament\Notifications\Notification;

/**
 * Edit YourModelName Record
 * 
 * This page provides a form to edit an existing YourModelName record.
 */
class EditYourModelName extends EditRecord
{
    protected static string $resource = YourResourceName::class;
    
    /**
     * Get the header actions for this page
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    /**
     * Create a notification after record update
     */
    protected function afterSave(): void
    {
        Notification::make()
            ->title('YourModelName updated')
            ->success()
            ->send();
    }
}
```

## Custom Page Template

```php
<?php

namespace App\Filament\Resources\YourResourceName\Pages;

use App\Filament\Resources\YourResourceName;
use Filament\Resources\Pages\Page;
use Filament\Actions;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;

/**
 * Custom YourModelName Page
 * 
 * This page provides custom functionality for YourModelName.
 */
class CustomYourModelNamePage extends Page
{
    protected static string $resource = YourResourceName::class;
    
    protected static string $view = 'filament.resources.your-model-name.pages.custom-page';
    
    /**
     * URL parameter for filtering/navigation
     */
    #[Url]
    public ?string $parameter = null;
    
    /**
     * Get computed data for the view
     */
    #[Computed]
    public function getComputedData(): array
    {
        // Implementation here
        return [];
    }
    
    /**
     * Get the header actions for this page
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('customAction')
                ->label('Custom Action')
                ->action(fn () => $this->customAction()),
        ];
    }
    
    /**
     * Custom action handler
     */
    public function customAction(): void
    {
        // Implementation here
    }
}
```

## Important Type Safety Notes

1. Always ensure properties match their parent class type declarations exactly:
   - `?string` for nullable string properties
   - `string` for non-nullable string properties
   - `array` for array properties
   - etc.

2. When using Livewire attributes, always import the related classes:
   - `use Livewire\Attributes\Url;` for `#[Url]`
   - `use Livewire\Attributes\Computed;` for `#[Computed]`
   - `use Livewire\Attributes\On;` for `#[On('event')]`

3. Never place `use` statements inside a class body.

4. Run PHPStan regularly to detect type mismatches:
   ```bash
   ./vendor/bin/phpstan analyse
   ```