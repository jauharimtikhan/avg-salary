@extends('welcome', ['title' => 'Data Pegawai'])

@section('content')
    <section class="text-gray-200 w-full bg-gray-700 py-4 px-6 rounded-lg">
        <div class="flex justify-between items-center">
            <h1 class="mb-6 text-2xl font-bold">Data Pegawai</h1>
            <button id="trigerModal" type="button"
                class="bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-700">Tambah</button>
        </div>
        <table class="w-full min-w-full">
            <thead class="bg-gray-800">
                <tr class="">
                    <th class="py-2 px-4 text-gray-200 border border-gray-400 w-10">No</th>
                    <th class="py-2 px-4 text-gray-200 border border-gray-400">Nama Pegawai</th>
                    <th class="py-2 px-4 text-gray-200 border border-gray-400 w-64">Action</th>
                </tr>
            </thead>
            <tbody class="bg-gray-600">
                @foreach ($buruhs as $buruh)
                    <tr class=" border-gray-400">
                        <td class="py-2 px-4 text-center border border-gray-400">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 text-center border border-gray-400">{{ $buruh->name }}</td>
                        <td class="py-2 px-6 flex justify-center border border-gray-400 gap-4 w-64">
                            @if (auth()->user()->role === 'administrator')
                                <a href="{{ route('pegawai.edit', $buruh->id) }}"
                                    class="bg-yellow-600 hover:bg-yellow-700 px-4 py-2 rounded-lg">Detail</a>
                            @endif
                            <button type="button"
                                class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg border-none"
                                data-id="{{ $buruh->id }}" data-nama="{{ $buruh->name }}" id="btnEdit"
                                onclick="edit(this)">Edit</button>
                            <button type="button" data-id="{{ $buruh->id }}" onclick="deletePegawai(this)"
                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg">Delete</button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    {{-- Modal Tambah Pegawai --}}
    <x-modal title="Tambah Pegawai" id="modal">
        <div class="mt-5 ">
            <form action="{{ route('pegawai.store') }}" method="post" class="form-add-pegawai">
                @csrf
                <div class="flex flex-col mb-3">
                    <label for="nama_pegawai" class="mb-2">Nama Pegawai</label>
                    <x-text-input type="text" placeholder="Masukkan Nama Pegawai" id="nama_pegawai"
                        name="nama_pegawai" />
                </div>
                <div class="mt-2 float-end">
                    <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- Modal Edit Pegawai --}}
    <x-modal title="Edit Pegawai" id="modalEdit">
        <div class="mt-5 ">
            <form method="post" class="form-edit-pegawai">
                <input type="hidden" name="id" id="id_edit">

                <div class="flex flex-col mb-3">
                    <label for="nama_pegawai" class="mb-2">Nama Pegawai</label>
                    <x-text-input type="text" placeholder="Masukkan Nama Pegawai" id="nama_pegawai_edit"
                        name="nama_pegawai" />
                </div>
                <div class="mt-2 float-end">
                    <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-700">Update</button>
                </div>
            </form>
        </div>
    </x-modal>
@endsection
@push('js')
    <script type="text/javascript">
        $('#trigerModal').on('click', () => {
            $('#modal').removeClass('hidden')
        })

        $('.form-add-pegawai').submit((e) => {
            e.preventDefault()
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: {
                    nama_pegawai: $('#nama_pegawai').val(),
                    _token: '{{ csrf_token() }}'
                },

                success: (res) => {
                    if (res.status === 200) {
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        }).then((success) => {
                            location.reload()
                        })
                    }
                },
                error: function(err) {
                    if (err.status === 422) {
                        let errors = err.responseJSON.errors
                        Object.keys(errors).forEach((key) => {
                            $(`[name="${key}"]`).after(
                                `<span class="text-red-500">${errors[key][0]}</span>`)
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: err.responseJSON.message
                        })
                    }
                }
            })
        })

        function edit(el) {
            let id = $(el).data('id')
            let namaBuruh = $(el).data('nama')
            $('#modalEdit').removeClass('hidden')
            $('#nama_pegawai_edit').val(namaBuruh)
            $('#id_edit').val(id)
        }

        $('.form-edit-pegawai').submit((e) => {
            e.preventDefault();
            $.ajax({
                url: '{{ route('pegawai.update') }}',
                method: 'POST',
                data: {
                    id: $('#id_edit').val(),
                    nama_pegawai: $('#nama_pegawai_edit').val(),
                    _token: '{{ csrf_token() }}'
                },

                success: (res) => {
                    if (res.status === 200) {
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        }).then((success) => {
                            location.reload()
                        })
                    }
                },
                error: function(err) {
                    if (err.status === 422) {
                        let errors = err.responseJSON.errors
                        Object.keys(errors).forEach((key) => {
                            $(`[name="${key}"]`).after(
                                `<span class="text-red-500">${errors[key][0]}</span>`)
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: err.responseJSON.message
                        })
                    }
                }
            })
        })

        function deletePegawai(el) {
            let id = $(el).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('pegawai.destroy', ':id') }}'.replace(':id', id),
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: (res) => {
                            if (res.status === 200) {
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                }).then((success) => {
                                    location.reload()
                                })
                            }
                        },
                        error: function(err) {
                            if (err.status === 404) {
                                Toast.fire({
                                    icon: 'error',
                                    title: err.responseJSON.message
                                })
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: err.responseJSON.message
                                })

                            }
                        }
                    })
                }
            })
        }
    </script>
@endpush
