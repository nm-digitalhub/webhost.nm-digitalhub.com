<?php

namespace App\Livewire\Client;

use Livewire\Component;

class DomainCheck extends Component
{
    public $domainName = '';

    public $searchResults = [];

    public $isSearching = false;

    protected $rules = [
        'domainName' => 'required|string|min:3|regex:/^[a-zA-Z0-9][a-zA-Z0-9-_.]+[a-zA-Z0-9]$/',
    ];

    public function checkDomain()
    {
        $this->validate();
        $this->isSearching = true;

        try {
            // Simulate API call delay
            sleep(1);

            // Parse domain properly
            $parts = explode('.', (string) $this->domainName);
            $tld = count($parts) >= 2 ? implode('.', array_slice($parts, -2)) : 'com';

            $this->searchResults = [
                'available' => true,
                'domain' => $this->domainName,
                'price' => 12.99,
                'tld' => $tld,
            ];
        } catch (\Exception) {
            $this->addError('domainName', 'Failed to check domain availability');
        } finally {
            $this->isSearching = false;
        }
    }

    public function render()
    {
        return view('livewire.client.domain-check')
            ->layout('layouts.client');
    }
}
