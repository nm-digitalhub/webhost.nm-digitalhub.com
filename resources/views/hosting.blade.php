@extends('layouts.app')


@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-6">Web Hosting Plans</h1>
                
                <p class="mb-8 text-lg">Choose the perfect hosting solution for your website.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <!-- Basic Plan -->
                    <div class="border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-gray-50 p-6 text-center border-b">
                            <h3 class="text-2xl font-bold">Basic</h3>
                            <div class="mt-4">
                                <span class="text-3xl font-bold">$4.99</span>
                                <span class="text-gray-500">/month</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    1 Website
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    10GB Storage
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Free SSL Certificate
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    24/7 Support
                                </li>
                            </ul>
                            <div class="mt-6">
                                <a href="#" class="block text-center py-2 px-4 bg-[#0084FF] hover:bg-[#00457C] text-white rounded-lg transition-colors">Select Plan</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Premium Plan -->
                    <div class="border rounded-xl overflow-hidden shadow-md relative">
                        <div class="absolute top-0 right-0 bg-[#0084FF] text-white text-xs font-bold px-3 py-1 rounded-bl-lg">POPULAR</div>
                        <div class="bg-gray-50 p-6 text-center border-b">
                            <h3 class="text-2xl font-bold">Premium</h3>
                            <div class="mt-4">
                                <span class="text-3xl font-bold">$9.99</span>
                                <span class="text-gray-500">/month</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Unlimited Websites
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    100GB Storage
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Free SSL Certificate
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    24/7 Priority Support
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Free Domain
                                </li>
                            </ul>
                            <div class="mt-6">
                                <a href="#" class="block text-center py-2 px-4 bg-[#0084FF] hover:bg-[#00457C] text-white rounded-lg transition-colors">Select Plan</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Business Plan -->
                    <div class="border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-gray-50 p-6 text-center border-b">
                            <h3 class="text-2xl font-bold">Business</h3>
                            <div class="mt-4">
                                <span class="text-3xl font-bold">$19.99</span>
                                <span class="text-gray-500">/month</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Unlimited Websites
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Unlimited Storage
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Free SSL Certificate
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    24/7 Priority Support
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Free Domain + Backups
                                </li>
                            </ul>
                            <div class="mt-6">
                                <a href="#" class="block text-center py-2 px-4 bg-[#0084FF] hover:bg-[#00457C] text-white rounded-lg transition-colors">Select Plan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="text-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight text-[#111827]">
            Web Hosting Plans
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl text-gray-500">
            Secure and reliable hosting for your website.
        </p>
    </div>

    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Basic Plan -->
        <div class="bg-white rounded-xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-4">Basic</h2>
            <p class="text-4xl font-bold text-center text-[#0084FF] mb-6">$4.99<span class="text-sm text-gray-500">/mo</span></p>
            <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>1 Website</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>10GB Storage</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Free SSL Certificate</span>
                </li>
            </ul>
            <div class="text-center">
                <a href="#" class="inline-block px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-md transition-colors uppercase w-full">Get Started</a>
            </div>
        </div>

        <!-- Premium Plan -->
        <div class="bg-white rounded-xl p-8 shadow-lg border-2 border-[#0084FF]">
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#0084FF] text-white px-4 py-1 rounded-full text-sm font-medium">MOST POPULAR</div>
            <h2 class="text-2xl font-bold text-center mb-4">Premium</h2>
            <p class="text-4xl font-bold text-center text-[#0084FF] mb-6">$8.99<span class="text-sm text-gray-500">/mo</span></p>
            <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Unlimited Websites</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>50GB Storage</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Free SSL Certificate</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Free Domain</span>
                </li>
            </ul>
            <div class="text-center">
                <a href="#" class="inline-block px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-md transition-colors uppercase w-full">Get Started</a>
            </div>
        </div>

        <!-- Business Plan -->
        <div class="bg-white rounded-xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-4">Business</h2>
            <p class="text-4xl font-bold text-center text-[#0084FF] mb-6">$14.99<span class="text-sm text-gray-500">/mo</span></p>
            <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Unlimited Websites</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>100GB Storage</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Free SSL Certificate</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Free Domain</span>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Dedicated Resources</span>
                </li>
            </ul>
            <div class="text-center">
                <a href="#" class="inline-block px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-md transition-colors uppercase w-full">Get Started</a>
            </div>
        </div>
    </div>
</div>
@endsection
