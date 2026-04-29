<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                    Sales Pages
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Create, preview, and manage your AI-generated sales pages.
                </p>
            </div>

            <a href="{{ route('sales-pages.create') }}"
            class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto sm:rounded-xl sm:px-5 sm:py-3">
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-white/20 text-sm leading-none">+</span>
                <span>New Sales Page</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
            @if (session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <section class="grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Total Pages</p>
                    <h3 class="mt-3 text-3xl font-bold text-gray-900">{{ $totalSalesPages }}</h3>
                    <p class="mt-2 text-sm text-gray-500">All generated sales pages</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Generated This Week</p>
                    <h3 class="mt-3 text-3xl font-bold text-gray-900">{{ $generatedThisWeek }}</h3>
                    <p class="mt-2 text-sm text-gray-500">Pages created in the current week</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Latest Generated</p>
                    <h3 class="mt-3 text-lg font-semibold text-gray-900">
                        {{ $latestSalesPage?->product_name ?? 'No data yet' }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ $latestSalesPage ? $latestSalesPage->created_at->format('d M Y, H:i') : 'Create your first sales page' }}
                    </p>
                </div>
            </section>

            <section class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900">Generated Sales Pages</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        View, regenerate, export, or delete your saved pages.
                    </p>
                </div>

                @if ($salesPages->isEmpty())
                    <div class="p-10 text-center">
                        <h4 class="text-lg font-semibold text-gray-900">No sales pages yet</h4>
                        <p class="mt-2 text-sm text-gray-500">
                            Start by generating your first sales page.
                        </p>
                        <a href="{{ route('sales-pages.create') }}"
                           class="mt-4 inline-flex items-center px-5 py-3 bg-indigo-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-indigo-700 transition">
                            Create Now
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach ($salesPages as $salesPage)
                            @php
                                $formattedPrice = $salesPage->price
                                    ? 'Rp' . number_format((int) preg_replace('/[^\d]/', '', $salesPage->price), 0, ',', '.')
                                    : '-';
                            @endphp

                            <div class="p-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between hover:bg-gray-50/60 transition">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <h4 class="text-2xl font-bold text-gray-900">
                                            {{ $salesPage->product_name }}
                                        </h4>

                                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-4 py-1.5 text-sm font-medium text-indigo-700">
                                            {{ $salesPage->created_at->format('d M Y H:i') }}
                                        </span>
                                    </div>

                                    <p class="mt-4 text-base text-gray-600 line-clamp-2">
                                        {{ $salesPage->headline ?? 'No headline generated yet.' }}
                                    </p>

                                    <div class="mt-4 flex flex-wrap gap-2 text-sm text-gray-500">
                                        <span class="rounded-full bg-gray-100 px-4 py-2">
                                            Audience: {{ $salesPage->target_audience ?: '-' }}
                                        </span>

                                        <span class="rounded-full bg-gray-100 px-4 py-2">
                                            Price: {{ $formattedPrice }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    
                                <a href="{{ route('sales-pages.show', $salesPage) }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold uppercase tracking-widest text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900">
                                    View
                                </a>

                                <a href="{{ route('sales-pages.edit', $salesPage) }}"
                                class="inline-flex items-center justify-center rounded-xl border border-indigo-200 bg-indigo-50 px-5 py-3 text-sm font-semibold uppercase tracking-widest text-indigo-700 shadow-sm transition hover:border-indigo-300 hover:bg-indigo-100 hover:text-indigo-800">
                                    Edit
                                </a>
<!-- 
                                    <a href="{{ route('sales-pages.export-html', $salesPage) }}"
                                       class="inline-flex items-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">
                                        Export HTML
                                    </a> -->

                                    <form action="{{ route('sales-pages.destroy', $salesPage) }}" method="POST" onsubmit="return confirm('Delete this sales page?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold uppercase tracking-widest text-red-700 shadow-sm transition hover:border-red-300 hover:bg-red-100 hover:text-red-800">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>