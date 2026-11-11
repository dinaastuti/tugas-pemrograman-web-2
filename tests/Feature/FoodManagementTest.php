<?php

use App\Models\Food;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the food inventory directly on the homepage', function () {
    Food::factory()->create([
        'name' => 'Nasi Goreng',
        'category' => 'Makanan Berat',
        'price' => 25000,
        'stock' => 4,
    ]);

    $this->get('/')
        ->assertOk()
        ->assertViewHas('foods', fn ($foods) => $foods->pluck('name')->all() === ['Nasi Goreng'])
        ->assertSee('Daftar Produk')
        ->assertSee('Nasi Goreng')
        ->assertDontSee('Dashboard')
        ->assertDontSee('Total Produk');
});

it('searches and filters foods and paginates results', function () {
    Food::factory()->create([
        'name' => 'Roti Cokelat',
        'category' => 'Roti dan Kue',
        'price' => 12000,
        'stock' => 3,
    ]);
    Food::factory()->create([
        'name' => 'Es Teh Manis',
        'category' => 'Minuman',
        'price' => 5000,
        'stock' => 20,
    ]);
    Food::factory()->create([
        'name' => 'Roti Keju',
        'category' => 'Roti dan Kue',
        'price' => 18000,
        'stock' => 7,
    ]);

    $this->get(route('foods.index', ['search' => 'Roti', 'category' => 'Roti dan Kue']))
        ->assertOk()
        ->assertSee('Roti Cokelat')
        ->assertSee('Roti Keju')
        ->assertDontSee('Es Teh Manis');

    $this->get(route('foods.index', ['sort' => 'price', 'direction' => 'asc']))
        ->assertViewHas('foods', fn ($foods) => $foods->pluck('name')->all() === [
            'Es Teh Manis',
            'Roti Cokelat',
            'Roti Keju',
        ]);

    Food::factory()->count(9)->create();

    $this->get(route('foods.index', ['per_page' => 5]))
        ->assertViewHas('foods', fn ($foods) => $foods->count() === 5 && $foods->total() === 12);
});

it('shows an empty state and rejects invalid listing filters', function () {
    $this->get(route('foods.index'))
        ->assertOk()
        ->assertSee('Belum ada data makanan');

    $this->get(route('foods.index', ['sort' => 'id desc']))
        ->assertSessionHasErrors('sort');
});
