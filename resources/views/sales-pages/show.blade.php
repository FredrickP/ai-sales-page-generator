<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sales Page Preview
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('sales-pages.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                    Back to History
                </a>

                <a href="{{ route('sales-pages.export-html', $salesPage) }}"
                class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">
                    Export HTML
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

        if (! is_array($benefits)) {
            $benefits = [];
        }

        if (! is_array($features)) {
            $features = [];
        }

        if (! is_array($socialProofs)) {
            $socialProofs = [];
        }

        if (! is_array($cta)) {
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
                <section class="px-8 py-14 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white">
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
                                <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-medium">
                                    {{ $formattedPrice }}
                                </span>
                            </div>
                        @endif

                        <div class="mt-8">
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
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Product Description</h2>
                                <p class="text-gray-700 leading-7 whitespace-pre-line">
                                    {{ $salesPage->description ?: 'No description provided.' }}
                                </p>
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
                            <div class="rounded-xl border border-gray-200 p-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Quick Info</h3>

                                <div class="space-y-3 text-sm text-gray-700">
                                    <div>
                                        <div class="font-semibold text-gray-900">Target Audience</div>
                                        <div>{{ $salesPage->target_audience ?: '-' }}</div>
                                    </div>

                                    <div>
                                        <div class="font-semibold text-gray-900">Price</div>
                                        <div>{{ $formattedPrice ?: '-' }}</div>
                                    </div>

                                    <div>
                                        <div class="font-semibold text-gray-900">Unique Selling Points</div>
                                        <div class="whitespace-pre-line">{{ $salesPage->unique_selling_points ?: '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-xl border border-gray-200 p-5 bg-gray-50">
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Social Proof</h3>

                                @if (!empty($socialProofs))
                                    <div class="space-y-4">
                                        @foreach ($socialProofs as $proof)
                                            <div class="rounded-lg bg-white border border-gray-200 p-4">
                                                <div class="font-semibold text-gray-900 mb-2">
                                                    {{ $proof['name'] ?? '-' }}
                                                </div>
                                                <p class="text-sm text-gray-700">
                                                    "{{ $proof['quote'] ?? '-' }}"
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-700">
                                        Social proof placeholder will appear here.
                                    </p>
                                @endif
                            </div>

                            <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-5">
                                <h3 class="text-lg font-bold text-indigo-900 mb-3">Call To Action</h3>
                                <p class="text-sm text-indigo-800">
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