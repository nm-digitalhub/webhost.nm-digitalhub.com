@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-6">Domain Search</h1>

                <p class="mb-4">Search for your perfect domain name and secure your online presence.</p>

                <form action="{{ route('search') }}" method="GET" class="mb-8">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input
                            type="text"
                            name="name"
                            placeholder="Enter domain name..."
                            class="flex-1 py-3 px-4 rounded-lg border-gray-300 focus:ring-2 focus:ring-[#0084FF] focus:outline-none"
                            required
                        >
                        <button
                            type="submit"
                            class="px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-lg transition-colors uppercase"
                        >
                            Search
                        </button>
                    </div>
                </form>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-3">.com Domains</h3>
                        <p class="text-gray-600 mb-4">The most popular domain extension for businesses worldwide.</p>
                        <span class="block text-[#0084FF] font-bold">Starting at $9.99/year</span>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-3">.net Domains</h3>
                        <p class="text-gray-600 mb-4">Ideal for technology, networking and infrastructure companies.</p>
                        <span class="block text-[#0084FF] font-bold">Starting at $11.99/year</span>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-3">.org Domains</h3>
                        <p class="text-gray-600 mb-4">Perfect for organizations, non-profits and communities.</p>
                        <span class="block text-[#0084FF] font-bold">Starting at $12.99/year</span>
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
            Domain Name Search
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl text-gray-500">
            Find the perfect domain name for your business or project.
        </p>
    </div>

    <!-- Search Bar -->
    <div class="mt-10 max-w-xl mx-auto">
        <form action="{{ route('search') }}" method="GET" class="flex flex-col sm:flex-row shadow-md">
            <input
                id="domain-search-input"
                type="text"
                name="name"
                placeholder="Find your domain name..."
                class="flex-1 py-3 px-4 rounded-t-lg sm:rounded-l-lg sm:rounded-tr-none border-0 focus:ring-2 focus:ring-[#0084FF] focus:outline-none"
                required
            >
            <button
                id="search-domain-button"
                type="submit"
                class="w-full sm:w-auto mt-2 sm:mt-0 px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-b-lg sm:rounded-r-lg sm:rounded-bl-none transition-colors uppercase"
            >
                Search
            </button>
        </form>
    </div>

    <!-- Domain Pricing Table -->
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-center mb-8">Domain Pricing</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="py-4 px-6 text-left text-gray-700">Domain Extension</th>
                        <th class="py-4 px-6 text-center text-gray-700">Registration</th>
                        <th class="py-4 px-6 text-center text-gray-700">Renewal</th>
                        <th class="py-4 px-6 text-center text-gray-700">Transfer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6 font-medium">.com</td>
                        <td class="py-4 px-6 text-center">$12.99</td>
                        <td class="py-4 px-6 text-center">$14.99</td>
                        <td class="py-4 px-6 text-center">$12.99</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6 font-medium">.net</td>
                        <td class="py-4 px-6 text-center">$14.99</td>
                        <td class="py-4 px-6 text-center">$16.99</td>
                        <td class="py-4 px-6 text-center">$14.99</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6 font-medium">.org</td>
                        <td class="py-4 px-6 text-center">$12.99</td>
                        <td class="py-4 px-6 text-center">$14.99</td>
                        <td class="py-4 px-6 text-center">$12.99</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6 font-medium">.io</td>
                        <td class="py-4 px-6 text-center">$39.99</td>
                        <td class="py-4 px-6 text-center">$39.99</td>
                        <td class="py-4 px-6 text-center">$39.99</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 font-medium">.co</td>
                        <td class="py-4 px-6 text-center">$24.99</td>
                        <td class="py-4 px-6 text-center">$24.99</td>
                        <td class="py-4 px-6 text-center">$24.99</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
