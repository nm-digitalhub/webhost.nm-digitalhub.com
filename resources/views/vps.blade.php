@extends('layouts.app')

@section('content')
<div class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="text-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight text-[#111827]">
            VPS Hosting Solutions
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl text-gray-500">
            Virtual Private Servers with full root access and dedicated resources.
        </p>
    </div>

    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Basic VPS -->
        <div class="bg-white rounded-xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-4">Basic VPS</h2>
            <p class="text-4xl font-bold text-center text-[#0084FF] mb-6">$19.99<span class="text-sm text-gray-500">/mo</span></p>
            <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>2 vCPU Cores</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>2GB RAM</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>50GB SSD Storage</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>1TB Bandwidth</span>
                </li>
            </ul>
            <div class="text-center">
                <a href="#" class="inline-block px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-md transition-colors uppercase w-full">Get Started</a>
            </div>
        </div>

        <!-- Standard VPS -->
        <div class="bg-white rounded-xl p-8 shadow-lg border-2 border-[#0084FF]">
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#0084FF] text-white px-4 py-1 rounded-full text-sm font-medium">MOST POPULAR</div>
            <h2 class="text-2xl font-bold text-center mb-4">Standard VPS</h2>
            <p class="text-4xl font-bold text-center text-[#0084FF] mb-6">$39.99<span class="text-sm text-gray-500">/mo</span></p>
            <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>4 vCPU Cores</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>8GB RAM</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>100GB SSD Storage</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>3TB Bandwidth</span>
                </li>
            </ul>
            <div class="text-center">
                <a href="#" class="inline-block px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-md transition-colors uppercase w-full">Get Started</a>
            </div>
        </div>

        <!-- Premium VPS -->
        <div class="bg-white rounded-xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-4">Premium VPS</h2>
            <p class="text-4xl font-bold text-center text-[#0084FF] mb-6">$79.99<span class="text-sm text-gray-500">/mo</span></p>
            <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>8 vCPU Cores</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>16GB RAM</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>200GB SSD Storage</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>5TB Bandwidth</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Dedicated IP</span>
                </li>
            </ul>
            <div class="text-center">
                <a href="#" class="inline-block px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-md transition-colors uppercase w-full">Get Started</a>
            </div>
        </div>
    </div>
</div>
@endsection
