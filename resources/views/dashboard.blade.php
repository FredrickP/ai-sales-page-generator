<x-app-layout>
    @php
        $user = auth()->user();
        $totalSalesPages = $user->salesPages()->count();
        $latestSalesPage = $user->salesPages()->latest()->first();
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold leading-tight text-gray-900">
                    Dashboard
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Welcome back, {{ $user->name }} 👋
                </p>
            </div>

            <a href="{{ route('sales-pages.index') }}"
               class="inline-flex items-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                Go to Sales Pages
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            <!-- Hero -->
            <section class="overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-blue-600 p-8 text-white shadow-lg">
                <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                    <div>
                        <p class="mb-3 inline-flex rounded-full bg-white/15 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-white/90">
                            AI Sales Page Generator
                        </p>

                        <h1 class="text-3xl font-bold leading-tight sm:text-4xl">
                            Build beautiful sales pages faster with AI
                        </h1>

                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/90 sm:text-base">
                            Generate structured sales page content, save your history, preview results,
                            regenerate content, and export to HTML — all in one simple dashboard.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('sales-pages.create') }}"
                               class="inline-flex items-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-indigo-700 shadow transition hover:bg-gray-100">
                                + Create Sales Page
                            </a>

                            <a href="{{ route('sales-pages.index') }}"
                               class="inline-flex items-center rounded-xl border border-white/30 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/20">
                                View History
                            </a>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-white/10 p-5 backdrop-blur-sm">
                            <p class="text-sm text-white/80">Total Sales Pages</p>
                            <h3 class="mt-2 text-3xl font-bold">{{ $totalSalesPages }}</h3>
                            <p class="mt-2 text-xs text-white/70">Generated and saved in your account</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-5 backdrop-blur-sm">
                            <p class="text-sm text-white/80">Latest Activity</p>
                            <h3 class="mt-2 text-lg font-semibold">
                                {{ $latestSalesPage?->product_name ?? 'No data yet' }}
                            </h3>
                            <p class="mt-2 text-xs text-white/70">
                                {{ $latestSalesPage ? $latestSalesPage->created_at->format('d M Y, H:i') : 'Start by creating your first sales page' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-5 backdrop-blur-sm sm:col-span-2">
                            <p class="text-sm text-white/80">Quick Summary</p>
                            <p class="mt-2 text-sm leading-6 text-white/90">
                                Use this dashboard to manage your AI-generated sales pages quickly.
                                Create new content, review previous results, and export polished HTML for your projects.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats -->
            <section class="grid gap-5 md:grid-cols-3">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500">Sales Pages Created</h3>
                        <div class="rounded-xl bg-indigo-100 p-2 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-3xl font-bold text-gray-900">{{ $totalSalesPages }}</p>
                    <p class="mt-2 text-sm text-gray-500">Total pages you have generated</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500">Account</h3>
                        <div class="rounded-xl bg-green-100 p-2 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-lg font-semibold text-gray-900">{{ $user->email }}</p>
                    <p class="mt-2 text-sm text-gray-500">Logged in as {{ $user->name }}</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500">Latest Sales Page</h3>
                        <div class="rounded-xl bg-yellow-100 p-2 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10m-12 9h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-lg font-semibold text-gray-900">
                        {{ $latestSalesPage?->product_name ?? 'No sales page yet' }}
                    </p>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ $latestSalesPage ? $latestSalesPage->created_at->diffForHumans() : 'Generate one now' }}
                    </p>
                </div>
            </section>

            <!-- Quick Actions -->
            <section class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm lg:col-span-2">
                    <h3 class="text-xl font-bold text-gray-900">Quick Actions</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Start working with your sales page project using the actions below.
                    </p>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <a href="{{ route('sales-pages.create') }}"
                           class="rounded-2xl border border-indigo-200 bg-indigo-50 p-5 transition hover:bg-indigo-100">
                            <h4 class="text-lg font-semibold text-indigo-900">Create New Sales Page</h4>
                            <p class="mt-2 text-sm text-indigo-700">
                                Fill in product details and let AI generate content for you.
                            </p>
                        </a>

                        <a href="{{ route('sales-pages.index') }}"
                           class="rounded-2xl border border-gray-200 bg-gray-50 p-5 transition hover:bg-gray-100">
                            <h4 class="text-lg font-semibold text-gray-900">Open Sales Page History</h4>
                            <p class="mt-2 text-sm text-gray-600">
                                View, manage, regenerate, or export previous sales pages.
                            </p>
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900">Tips</h3>
                    <ul class="mt-4 space-y-3 text-sm text-gray-600">
                        <li>• Use clear product names.</li>
                        <li>• Write short but specific descriptions.</li>
                        <li>• Add strong unique selling points.</li>
                        <li>• Review AI output before exporting HTML.</li>
                    </ul>
                </div>
            </section>

            <!-- Latest Item -->
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Latest Generated Sales Page</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Quickly access your most recent result.
                        </p>
                    </div>

                    <a href="{{ route('sales-pages.index') }}"
                       class="inline-flex items-center rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        See All
                    </a>
                </div>

                @if ($latestSalesPage)
                    <div class="mt-6 rounded-2xl border border-gray-200 bg-gray-50 p-5">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">
                                    {{ $latestSalesPage->product_name }}
                                </h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    Created {{ $latestSalesPage->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>

                            <a href="{{ route('sales-pages.show', $latestSalesPage->id) }}"
                               class="inline-flex items-center rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800">
                                View Detail
                            </a>
                        </div>
                    </div>
                @else
                    <div class="mt-6 rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-10 text-center">
                        <h4 class="text-lg font-semibold text-gray-900">No sales page yet</h4>
                        <p class="mt-2 text-sm text-gray-500">
                            Start by generating your first sales page.
                        </p>
                        <a href="{{ route('sales-pages.create') }}"
                           class="mt-4 inline-flex items-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            Create Now
                        </a>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>