<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;

    // General Settings
    public $company_name = 'NM-DigitalHUB';
    public $company_address = '';
    public $company_email = '';
    public $company_phone = '';
    public $company_vat = '';

    // System Defaults
    public $default_language = 'en';
    public $default_currency = 'USD';
    public $date_format = 'Y-m-d';

    // Appearance Settings
    public $color_scheme = 'blue';
    public $default_theme = 'system';
    public $direction = 'rtl';
    public $logo;

    protected $rules = [
        'company_name' => 'required|string|max:191',
        'company_email' => 'required|email|max:191',
        'company_phone' => 'nullable|string|max:20',
        'company_address' => 'nullable|string|max:255',
        'company_vat' => 'nullable|string|max:50',
        'default_language' => 'required|string|in:en,he,ar',
        'default_currency' => 'required|string|in:USD,EUR,ILS',
        'date_format' => 'required|string',
        'color_scheme' => 'required|string|in:blue,green,purple',
        'default_theme' => 'required|string|in:light,dark,system',
        'direction' => 'required|string|in:ltr,rtl',
        'logo' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        // Load settings from database in a real application
        // For now using default values
    }

    public function saveGeneralSettings()
    {
        $this->validate([
            'company_name' => 'required|string|max:191',
            'company_email' => 'required|email|max:191',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:255',
            'company_vat' => 'nullable|string|max:50',
        ]);

        // Save to database in a real application

        session()->flash('message', __('General settings updated successfully.'));
    }

    public function saveSystemDefaults()
    {
        $this->validate([
            'default_language' => 'required|string|in:en,he,ar',
            'default_currency' => 'required|string|in:USD,EUR,ILS',
            'date_format' => 'required|string',
        ]);

        // Save to database in a real application

        session()->flash('message', __('System defaults updated successfully.'));
    }

    public function saveAppearanceSettings()
    {
        $this->validate([
            'color_scheme' => 'required|string|in:blue,green,purple',
            'default_theme' => 'required|string|in:light,dark,system',
            'direction' => 'required|string|in:ltr,rtl',
            'logo' => 'nullable|image|max:1024',
        ]);

        if ($this->logo) {
            // Handle logo upload in a real application
            // $logoPath = $this->logo->store('logos', 'public');
            // Save $logoPath to settings
        }

        // Save to database in a real application

        session()->flash('message', __('Appearance settings updated successfully.'));
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('layouts.admin');
    }
}
