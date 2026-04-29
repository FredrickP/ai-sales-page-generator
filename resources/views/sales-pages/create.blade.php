<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Sales Page
            </h2>

            <a href="{{ route('sales-pages.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
               Sales Overview
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900">Generate a Sales Page</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Fill in your product or service details, then generate a structured sales page preview.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                            <div class="font-semibold text-red-700 mb-2">Please fix the following:</div>
                            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sales-pages.store') }}" method="POST" class="space-y-6" x-data="{ loading: false }" @submit="loading = true">
                        @csrf

                        <div>
                            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Product / Service Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="product_name"
                                name="product_name"
                                value="{{ old('product_name') }}"
                                placeholder="e.g. Smart CRM Pro"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Describe your product or service..."
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label for="key_features" class="block text-sm font-medium text-gray-700 mb-2">
                                Key Features
                            </label>
                            <textarea
                                id="key_features"
                                name="key_features"
                                rows="4"
                                placeholder="e.g. Automation, Analytics Dashboard, Team Collaboration"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('key_features') }}</textarea>
                            <p class="mt-2 text-xs text-gray-500">
                                Separate features with commas for better display.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-2">
                                    Target Audience
                                </label>
                                <input
                                    type="text"
                                    id="target_audience"
                                    name="target_audience"
                                    value="{{ old('target_audience') }}"
                                    placeholder="e.g. Small business owners"
                                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Price
                                </label>
                                <input
                                    type="text"
                                    id="price"
                                    name="price"
                                    value="{{ old('price') }}"
                                    placeholder="e.g. 299000"
                                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="unique_selling_points" class="block text-sm font-medium text-gray-700 mb-2">
                                Unique Selling Points
                            </label>
                            <textarea
                                id="unique_selling_points"
                                name="unique_selling_points"
                                rows="4"
                                placeholder="What makes your product different?"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('unique_selling_points') }}</textarea>
                        </div>

                        <div class="pt-2 flex items-center gap-3">
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center px-5 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition disabled:opacity-70 disabled:cursor-not-allowed"
                                x-bind:disabled="loading"
                            >
                                <span x-show="!loading">Generate Sales Page</span>
                                <span x-show="loading">Generating...</span>
                            </button>

                            <a
                                href="{{ route('sales-pages.index') }}"
                                class="inline-flex items-center px-5 py-3 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>