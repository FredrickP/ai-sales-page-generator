<?php

namespace App\Http\Controllers;

use App\Models\SalesPage;
use App\Services\SalesPageAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SalesPageController extends Controller
{
    public function __construct(
        private readonly SalesPageAiService $salesPageAiService
    ) {
    }

    public function index()
    {
        $salesPages = SalesPage::where('user_id', Auth::id())
            ->latest()
            ->get();
    
        $totalSalesPages = $salesPages->count();
    
        $generatedThisWeek = $salesPages->filter(function ($salesPage) {
            return $salesPage->created_at->greaterThanOrEqualTo(now()->startOfWeek());
        })->count();
    
        $latestSalesPage = $salesPages->first();
    
        return view('sales-pages.index', compact(
            'salesPages',
            'totalSalesPages',
            'generatedThisWeek',
            'latestSalesPage'
        ));
    }

    public function create()
    {
        return view('sales-pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'key_features' => ['nullable', 'string'],
            'target_audience' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'string', 'max:255'],
            'unique_selling_points' => ['nullable', 'string'],
        ]);

        try {
            $generated = $this->salesPageAiService->generate($validated);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'ai_error' => 'Failed to generate sales page. Please make sure Ollama is running.',
                ]);
        }

        $salesPage = SalesPage::create([
            'user_id' => Auth::id(),
            'product_name' => $validated['product_name'],
            'description' => $validated['description'] ?? null,
            'key_features' => $validated['key_features'] ?? null,
            'target_audience' => $validated['target_audience'] ?? null,
            'price' => $validated['price'] ?? null,
            'unique_selling_points' => $validated['unique_selling_points'] ?? null,
            'headline' => $generated['headline'],
            'subheadline' => $generated['subheadline'],
            'benefits' => $generated['benefits'],
            'features_breakdown' => $generated['features_breakdown'],
            'social_proof' => $generated['social_proof'],
            'cta' => $generated['cta'],
            'full_output' => $generated['full_output'],
        ]);

        return redirect()->route('sales-pages.show', $salesPage);
    }

    public function show(SalesPage $salesPage)
    {
        abort_if($salesPage->user_id !== Auth::id(), 403);

        return view('sales-pages.show', compact('salesPage'));
    }

    public function regenerate(SalesPage $salesPage)
    {
        abort_if($salesPage->user_id !== Auth::id(), 403);

        $payload = [
            'product_name' => $salesPage->product_name,
            'description' => $salesPage->description,
            'key_features' => $salesPage->key_features,
            'target_audience' => $salesPage->target_audience,
            'price' => $salesPage->price,
            'unique_selling_points' => $salesPage->unique_selling_points,
        ];

        try {
            $generated = $this->salesPageAiService->generate($payload);
        } catch (\Throwable $e) {
            return back()->withErrors([
                'ai_error' => 'Failed to regenerate sales page. Please make sure Ollama is running.',
            ]);
        }

        $salesPage->update([
            'headline' => $generated['headline'],
            'subheadline' => $generated['subheadline'],
            'benefits' => $generated['benefits'],
            'features_breakdown' => $generated['features_breakdown'],
            'social_proof' => $generated['social_proof'],
            'cta' => $generated['cta'],
            'full_output' => $generated['full_output'],
        ]);

        return redirect()
            ->route('sales-pages.show', $salesPage)
            ->with('success', 'Sales page regenerated successfully.');
    }

    public function exportHtml(SalesPage $salesPage)
    {
        abort_if($salesPage->user_id !== Auth::id(), 403);

        $html = view('sales-pages.export-html', [
            'salesPage' => $salesPage,
        ])->render();

        $fileName = Str::slug($salesPage->product_name ?: 'sales-page') . '.html';

        return response()->make($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function destroy(SalesPage $salesPage)
    {
        abort_if($salesPage->user_id !== Auth::id(), 403);

        $salesPage->delete();

        return redirect()
            ->route('sales-pages.index')
            ->with('success', 'Sales page deleted successfully.');
    }
}