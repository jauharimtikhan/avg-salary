@extends('welcome', ['title' => 'Form Salary'])

@section('content')
    <form action="{{ route('calculate') }}" method="post" class="w-full" autocomplete="off">
        <section class="text-gray-200 w-full">
            <h1 class="text-center mb-6 text-2xl font-bold">Pembagian Bonus Gaji</h1>
            @csrf

            <div class="flex flex-col gap-3">
                <label for="pembayaran">Pembayaran</label>
                <input type="Rp" name="total_pembayaran" id="pembayaran" placeholder="Masukkan nominal pembayaran"
                    class="w-full rounded-lg h-10 px-4 text-gray-600 focus:border-none focus:outline-none active:border-none active:outline-none">
            </div>
        </section>
        <section class="text-gray-200 bg-gray-200 mt-9 py-2 px-4 w-full overflow-hidden rounded-lg">
            <ul id="renderBuruh" class="mb-3"></ul>
            <div class="float-end">
                <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-700">Submit</button>
            </div>
        </section>
    </form>
@endsection
@push('js')
    <script type="text/javascript">
        const dataBuruh = @json($pegawais);
        $(document).ready(function() {

            $('#pembayaran').on('input', function() {
                let input = $(this);
                let pembayaran = input.val().replace(/[^0-9]/g, '');
                if (pembayaran === "") {
                    input.val("");
                    return;
                }
                let formattedPembayaran = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(pembayaran);


                input.val(formattedPembayaran);

            });
            if (localStorage.getItem('totalPembayaran') === null) {
                let totalPembayaran = $('#pembayaran').val();
                localStorage.setItem('totalPembayaran', totalPembayaran);
            } else {

                localStorage.setItem('totalPembayaran', $('#pembayaran').val());
                $('#pembayaran').val(localStorage.getItem('totalPembayaran'));
            }

            $.each(dataBuruh, function(index, value) {
                $('#renderBuruh').append(`

                    <li class="flex items-center select-none py-3">
                        <input type="hidden" name="names[]" value="${value['name']}"/>
                        <span class="pr-4 text-gray-900">${value['name']} : </span>
                        <div><input type="number" name="percentages[]" id="buruh-${value['id']}" min="0" max="100" class="w-20 text-gray-800 px-2 py-1 active:outline-none focus:outline-none rounded-lg shadow-sm" value="0"/></div>
                    </li>`);
            })


        });
    </script>
@endpush
