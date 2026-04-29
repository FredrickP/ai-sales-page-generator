<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sales Page Preview
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('sales-pages.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                    Sales Overview
                </a>

                <a href="{{ route('sales-pages.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Create New
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $benefits = json_decode($salesPage->benefits ?? '[]', true);
        $features = json_decode($salesPage->features_breakdown ?? '[]', true);
        $socialProofs = json_decode($salesPage->social_proof ?? '[]', true);
        $cta = json_decode($salesPage->cta ?? '{}', true);

        if (!is_array($benefits)) {
            $benefits = [];
        }

        if (!is_array($features)) {
            $features = [];
        }

        if (!is_array($socialProofs)) {
            $socialProofs = [];
        }

        if (!is_array($cta)) {
            $cta = [];
        }

        $formattedPrice = $salesPage->price;

        if (is_numeric(preg_replace('/[^\d]/', '', (string) $salesPage->price))) {
            $formattedPrice = 'Rp' . number_format((int) preg_replace('/[^\d]/', '', (string) $salesPage->price), 0, ',', '.');
        }
    @endphp

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $salesPage->product_name }}</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Generated on {{ $salesPage->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <form action="{{ route('sales-pages.regenerate', $salesPage) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Regenerate
                            </button>
                        </form>

                        <a href="{{ route('sales-pages.export-html', $salesPage) }}"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">
                            Export HTML
                        </a>

                        <form action="{{ route('sales-pages.destroy', $salesPage) }}" method="POST"
                            onsubmit="return confirm('Delete this sales page?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <section class="px-8 py-14 bg-gradient-to-r from-slate-900 via-gray-900 to-slate-800 text-white">
                    <div class="max-w-3xl">
                        <p class="text-sm uppercase tracking-[0.2em] text-indigo-100 mb-4">AI Sales Page Preview</p>
                        <h1 class="text-4xl font-extrabold leading-tight">
                            {{ $salesPage->headline ?? 'Your headline goes here' }}
                        </h1>
                        <p class="mt-4 text-lg text-indigo-100">
                            {{ $salesPage->subheadline ?? 'Your subheadline goes here' }}
                        </p>

                        @if ($formattedPrice)
                            <div class="mt-8">
                                <span
                                    class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-medium">
                                    {{ $formattedPrice }}
                                </span>
                            </div>
                        @endif
                        <div class="mt-8 flex flex-wrap gap-3">
                            <button
                                class="inline-flex items-center px-6 py-3 bg-white text-indigo-700 rounded-lg font-bold text-sm uppercase tracking-widest">
                                {{ $cta['button_text'] ?? 'Get Started' }}
                            </button>
                        </div>
                    </div>
                </section>

                <section class="px-8 py-12">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-8">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-gray-900 mb-1">Product Description</h2>

                                <div class="rounded-2xl border border-indigo-100 bg-indigo-50/60 p-4">
                                    <p class="text-sm leading-6 text-gray-700 whitespace-pre-line">
                                        {{ trim($salesPage->description ?? '') ?: 'No description provided.' }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Benefits</h2>

                                @if (!empty($benefits))
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($benefits as $benefit)
                                            <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                                                <div class="font-semibold text-gray-900 mb-2">
                                                    {{ $benefit['name'] ?? '-' }}
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    {{ $benefit['description'] ?? '-' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-600">No benefits available.</p>
                                @endif
                            </div>

                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Features</h2>

                                @if (!empty($features))
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($features as $feature)
                                            <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                                                <div class="font-semibold text-gray-900 mb-2">
                                                    {{ $feature['title'] ?? '-' }}
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    {{ $feature['description'] ?? '-' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-600">No features added.</p>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                                <div class="mb-5 flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100">
                                        <svg class="h-5 w-5 text-slate-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                        </svg>
                                    </div>

                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">
                                            Overview
                                        </p>
                                        <h3 class="text-lg font-semibold text-slate-900">
                                            Quick Info
                                        </h3>
                                    </div>
                                </div>

                                <div class="space-y-5">
                                    <div class="border-b border-slate-100 pb-4">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                                            Target Audience
                                        </p>
                                        <p class="mt-1 text-lg font-semibold text-slate-900">
                                            {{ $salesPage->target_audience ?: '-' }}
                                        </p>
                                    </div>

                                    <div class="border-b border-slate-100 pb-4">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                                            Price
                                        </p>
                                        <p class="mt-1 text-lg font-semibold text-slate-900">
                                            {{ $formattedPrice ?: '-' }}
                                        </p>
                                    </div>
                                    <div class="border-b border-slate-100 pb-4">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                                            Unique Selling Points
                                        </p>
                                        <p class="mt-1 text-lg font-semibold text-slate-900">
                                            {{ $salesPage->unique_selling_points ?: '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                                <h3 class="text-lg font-semibold text-slate-900 mb-4">Social Proof</h3>

                                @if (!empty($socialProofs))
                                    <div class="space-y-4">
                                        @foreach ($socialProofs as $proof)
                                            <div class="rounded-xl border border-slate-200 bg-white p-4">
                                                <div class="text-sm font-semibold text-slate-900 mb-2">
                                                    {{ $proof['name'] ?? '-' }}
                                                </div>
                                                <p class="text-sm leading-6 text-slate-600">
                                                    "{{ $proof['quote'] ?? '-' }}"
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-slate-600">
                                        Social proof placeholder will appear here.
                                    </p>
                                @endif
                            </div>

                            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-6 shadow-sm">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-500 mb-2">
                                    CTA
                                </p>
                                <h3 class="text-lg font-semibold text-emerald-900 mb-2">Call To Action</h3>
                                <p class="text-sm leading-6 text-emerald-800">
                                    {{ $cta['button_text'] ?? 'Get Started Now' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>