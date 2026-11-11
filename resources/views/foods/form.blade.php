@php($isEditing = $food->exists)

<x-app :title="$isEditing ? 'Edit Makanan' : 'Tambah Makanan'">
    <form action="{{ $isEditing ? route('foods.update', $food) : route('foods.store') }}" method="POST">
        @csrf
        @if ($isEditing)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label" for="name">Nama makanan</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $food->name) }}" maxlength="255" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="category">Kategori</label>
            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(old('category', $food->category) === $category)>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="price">Harga (Rupiah)</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                value="{{ old('price', $food->price) }}" min="0" max="9999999999.99" step="0.01" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="stock">Jumlah stok</label>
            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock"
                value="{{ old('stock', $food->stock) }}" min="0" max="2147483647" step="1" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if ($errors->any())
            <p class="alert alert-danger" role="alert">Periksa kembali data yang Anda masukkan.</p>
        @endif

        <div class="d-flex gap-2">
            <a class="btn btn-warning" href="{{ route('foods.index') }}" role="button">Batal</a>
            <button type="submit" class="btn btn-primary">
                {{ $isEditing ? 'Simpan perubahan' : 'Simpan makanan' }}
            </button>
        </div>
    </form>
</x-app>
