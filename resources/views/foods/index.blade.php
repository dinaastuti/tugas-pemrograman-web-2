<x-app title="Data Makanan">
    <div class="mb-3">
        <h2>Daftar Produk</h2>
    </div>

    <form class="row g-3 align-items-end mb-4" action="{{ route('foods.index') }}" method="GET">
        <div class="col-md-5">
            <label class="form-label" for="search">Cari nama</label>
            <input class="form-control" id="search" type="search" name="search"
                value="{{ $filters['search'] ?? '' }}">
        </div>

        <div class="col-md-4">
            <label class="form-label" for="category">Kategori</label>
            <select class="form-select" id="category" name="category">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-primary" type="submit">Cari</button>
            @if ($hasFilters)
                <a class="btn btn-secondary" href="{{ route('foods.index') }}">Hapus filter</a>
            @endif
        </div>
    </form>

    @if ($foods->isEmpty())
        <p class="alert alert-info" role="status">
            {{ $hasSearchFilters ? 'Produk tidak ditemukan.' : 'Belum ada data makanan.' }}
        </p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered border-primary table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nama makanan</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($foods as $food)
                        <tr>
                            <td>{{ $food->name }}</td>
                            <td>{{ $food->category }}</td>
                            <td>Rp {{ number_format((float) $food->price, 0, ',', '.') }}</td>
                            <td>{{ $food->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $foods->links('pagination::bootstrap-5') }}
    @endif
</x-app>
