<form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Title --}}
    <div class="mb-4">
        <label for="title" class="block text-gray-700 font-bold mb-2">Judul</label>
        <input type="text" name="title" value="{{ old('title', $blog->title) }}" required class="w-full border p-3 rounded-md">
        @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- Content --}}
    <div class="mb-4">
        <label for="content" class="block text-gray-700 font-bold mb-2">Konten</label>
        <textarea name="content" rows="5" class="w-full border p-3 rounded-md">{{ old('content', $blog->content) }}</textarea>
        @error('content') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- Kategori --}}
    <div class="mb-4">
        <label for="kategori" class="block text-gray-700 font-bold mb-2">Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori', $blog->kategori) }}" class="w-full border p-3 rounded-md">
        @error('kategori') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- Subkategori --}}
    <div class="mb-4">
        <label for="subkategori" class="block text-gray-700 font-bold mb-2">Subkategori</label>
        <input type="text" name="subkategori" value="{{ old('subkategori', $blog->subkategori) }}" class="w-full border p-3 rounded-md">
        @error('subkategori') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- Video --}}
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Video</label>
        <input type="file" name="video" accept="video/*" class="w-full border p-3 rounded-md">
        @error('video') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- Gambar --}}
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Gambar</label>
        <input type="file" name="images[]" multiple accept="image/*" class="w-full border p-3 rounded-md">
        @error('images.*') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-custom-blue text-white px-4 py-2 rounded hover:bg-blue-700">Update Blog</button>
    </div>
</form>
