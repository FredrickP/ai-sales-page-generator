<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sales Page History
            </h2>

            <a href="{{ route('sales-pages.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + New Sales Page
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
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

            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Your Generated Sales Pages</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        View, preview, and manage all generated pages here.
                    </p>
                </div>

                @if ($salesPages->isEmpty())
                    <div class="p-10 text-center">
                        <div class="text-lg font-semibold text-gray-800 mb-2">No sales pages yet</div>
                        <p class="text-sm text-gray-500 mb-6">
                            Start by generating your first sales page.
                        </p>
                        <a href="{{ route('sales-pages.create') }}"
                           class="inline-flex items-center px-5 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Create First Sales Page
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach ($salesPages as $salesPage)
                            <div class="p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900 truncate">
                                            {{ $salesPage->product_name }}
                                        </h4>
                                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                                            {{ $salesPage->created_at->format('d M Y H:i') }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600 line-clamp-2">
                                        {{ $salesPage->headline ?? 'No headline generated yet.' }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3 shrink-0">
                                    <a href="{{ route('sales-pages.show', $salesPage) }}"
                                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                                        View
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
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>