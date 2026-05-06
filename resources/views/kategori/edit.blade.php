<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
</head>
<body>
    <h1>Edit Data Kategori</h1>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategori.update', $kategori->ID_KATEGORI) }}" method="POST">
        @csrf
        @method('PUT') <div style="margin-bottom: 10px;">
            <label>Nama Kategori:</label><br>
            <input type="text" name="NAMA_KATEGORI" value="{{ $kategori->NAMA_KATEGORI }}" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label>Icon Kategori (Opsional):</label><br>
            <input type="text" name="ICON" value="{{ $kategori->ICON }}">
        </div>

        <button type="submit" style="padding: 10px; background: orange; color: white; border: none; cursor: pointer;">Update Data</button>
        <a href="{{ route('kategori.index') }}" style="margin-left: 10px;">Batal</a>
    </form>

</body>
</html>