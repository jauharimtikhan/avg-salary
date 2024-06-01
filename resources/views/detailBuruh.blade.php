@extends('welcome', ['title' => 'Detail Buruh'])
@section('content')
    <section class="text-gray-200 w-full">
        <h1 class="mb-6 text-2xl font-bold">Detail Buruh</h1>
        <div class="bg-gray-500 w-full py-4 px-4 rounded-lg mb-5">
            <ul>
                <li>Nama : {{ $buruh->name }}</li>
                <li>Gaji : <span id="salaryBuruh"></span></li>
            </ul>
        </div>
        <a href="{{ route('pegawai.index') }}" class="bg-gray-600 px-4 py-2 rounded-lg hover:bg-gray-700">&larr; Kembali</a>
    </section>
@endsection
@push('js')
    <script type="text/javascript">
        $('#salaryBuruh').text(RP('{{ $buruh->salary }}'));
    </script>
@endpush
