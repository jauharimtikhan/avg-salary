<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - Pembagian Bonus Gaji</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900">
    @if (auth()->user())
        <nav class="flex lg:flex-row md:flex-col sm:flex-col items-center bg-gray-800 py-2 px-4">
            <h1 class="text-3xl font-bold  text-gray-200">Pembagian Bonus Gaji</h1>
            <ul class="text-gray-200 lg:pl-24 md:mt-3 flex flex-row gap-10">
                <li class="hover:text-gray-400">
                    <a href="{{ route('home') }}">Pembayaran</a>
                </li>
                <li class="hover:text-gray-400">
                    <a href="{{ route('pegawai.index') }}">Daftar Pegawai</a>
                </li>
                <li class="hover:text-gray-200 bg-red-500 py-1 px-4 rounded-lg hover:bg-red-700">
                    <a href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
            <div class="lg:ml-auto ">
                <span class="text-gray-200  text-xl">Role : {{ ucfirst(auth()->user()->role) }}</span>
            </div>
        </nav>
    @endif
    <div class="flex flex-col items-center justify-center {{ auth()->user() ? 'py-12' : 'h-screen' }} px-24">
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        const Toast = Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        $('.modal-close').on('click', (e) => {
            $(e.target.parentElement.parentElement).addClass('hidden');
        })

        function RP(value) {
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            })

            return formatter.format(value)
        }
    </script>
    @stack('js')

    @if (session()->has('success'))
        <script type="text/javascript">
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        </script>
    @elseif(session()->has('error'))
        <script type="text/javascript">
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        </script>
    @endif
</body>

</html>
