@extends('welcome', ['title' => 'Login'])

@section('content')
    <section class="text-gray-200 w-96 bg-gray-600 py-4 px-6 rounded-lg">
        <h1 class="text-center mb-6 text-2xl font-bold">Login</h1>
        <form action="{{ route('login.store') }}" method="post">
            @csrf
            <div class="flex flex-col mb-3">
                <label for="email" class="text-gray-200 mb-2">Email</label>
                <input type="text" name="email" id="email" placeholder="Masukkan Email"
                    class="w-full rounded-lg h-10 px-4 text-gray-600 focus:border-none focus:outline-none active:border-none active:outline-none">
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col mb-3">
                <label for="password" class="text-gray-200 mb-2">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password"
                    class="w-full rounded-lg h-10 px-4 text-gray-600 focus:border-none focus:outline-none active:border-none active:outline-none">
                @error('password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="float-end">
                <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-700">Login</button>
            </div>
        </form>
    </section>
    <section class="text-gray-200 bg-gray-700 mt-9 py-2 px-4 w-auto overflow-hidden rounded-lg">
        <div class="flex justify-center gap-5">
            <p class="border py-2 px-4">
                Login Administrator :
                <br>
                email: admin@test.com
                <br>
                password: admin123
            </p>
            <p class="border py-2 px-4">
                Login Regular User :
                &nbsp;
                <br>
                email: user@test.com
                <br>
                password: user123
            </p>
        </div>
    </section>
@endsection
@push('js')
    <script type="text/javascript"></script>
@endpush
