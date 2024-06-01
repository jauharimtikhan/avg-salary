@props(['title', 'id'])
<div class="bg-gray-800 text-gray-200 hidden z-[999999] w-[500px] absolute top-60 py-2 px-4 rounded-lg shadow-lg"
    id="{{ $id }}">
    <div class="flex justify-between items-center gap-5">
        <h1 class="text-2xl text-gray-200">{{ $title }}</h1>
        <button class="modal-close">&times;</button>
    </div>
    {{ $slot }}
</div>
