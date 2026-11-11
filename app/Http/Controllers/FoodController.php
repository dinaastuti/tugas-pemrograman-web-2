<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FoodController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', Rule::in(Food::CATEGORIES)],
            'sort' => ['nullable', Rule::in(['name', 'category', 'price', 'stock', 'created_at'])],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
            'per_page' => ['nullable', 'integer', 'min:5', 'max:50'],
        ]);

        $sort = $filters['sort'] ?? 'created_at';
        $direction = $filters['direction'] ?? 'desc';
        $foods = Food::query()
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->when($filters['category'] ?? null, fn ($query, $category) => $query->where('category', $category))
            ->orderBy($sort, $direction)
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();

        return view('foods.index', [
            'foods' => $foods,
            'categories' => Food::CATEGORIES,
            'filters' => $filters,
            'hasFilters' => $request->query() !== [],
            'hasSearchFilters' => filled($filters['search'] ?? null) || filled($filters['category'] ?? null),
        ]);
    }

    public function create(): View
    {
        return view('foods.form', [
            'food' => new Food,
            'categories' => Food::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Food::create($this->validatedData($request));

        return redirect()->route('foods.index')->with('success', 'Makanan berhasil ditambahkan.');
    }

    public function edit(Food $food): View
    {
        return view('foods.form', [
            'food' => $food,
            'categories' => Food::CATEGORIES,
        ]);
    }

    public function update(Request $request, Food $food): RedirectResponse
    {
        $food->update($this->validatedData($request));

        return redirect()->route('foods.index')->with('success', 'Perubahan makanan berhasil disimpan.');
    }

    /**
     * @return array{name: string, category: string, price: string, stock: int}
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::in(Food::CATEGORIES)],
            'price' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:9999999999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:2147483647'],
        ]);
    }
}
