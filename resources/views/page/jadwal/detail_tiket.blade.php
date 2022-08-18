@extends('master')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection



@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row align-items-end">
            <div class="col-lg-10">
                <h1 class="h3 mb-2 text-gray-800">Detail Tiket</h1>
                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed rutrum nibh sit amet
                    diam fermentum fermentum. Nullam eu sapien dapibus magna dapibus ultricies. Pellentesque facilisis nibh
                    et ipsum vehicula convallis. Nunc non ex non ipsum tristique fermentum aliquet sed risus. Nullam vel
                    dolor ac orci mattis pellentesque. Quisque magna sem, pharetra placerat sagittis sit amet, aliquet id
                    nisi. Curabitur nec diam ut massa auctor maximus nec non sem.</p>
            </div>
            <div class="col-lg-2">
                <a href="{{ route('tiketPenumpang.create') }}" class="btn btn-primary btn-icon-split float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Baru </span>
                </a>
            </div>

        </div>
        <div class="my-2"></div>


        <!-- DataTales Example -->
        @if ($jadwal->jenis_kapal == 'Penumpang' || $jadwal->jenis_kapal == 'Penumpang & Kendaraan')
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Tiket Penumpang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kelas Tiket</th>
                                    <th>Total Tiket</th>
                                    <th>Jumlah Tiket Tersisa</th>
                                    <th>Harga Tiket Balita</th>
                                    <th>Harga Tiket Dewasa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Kelas Tiket</th>
                                    <th>Total Tiket</th>
                                    <th>Jumlah Tiket Tersisa</th>
                                    <th>Harga Tiket Balita</th>
                                    <th>Harga Tiket Dewasa</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($penumpang as $d)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$d->kelas_tiket}}</td>
                                        <td>{{$d->jumlah_tiket}}</td>
                                        <td>{{$d->sisa_tiket}}</td>
                                        <td>{{$d->harga_balita}}</td>
                                        <td>{{$d->harga_dewasa}}</td>


                                        <td>
                                            <a href="{{ route('tiketPenumpang.edit', $d->id_tiket) }}" class="btn btn-info">
                                                <span class="icon text-white">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-danger deleteButton" data="{{ route('tiketPenumpang.destroy', $d->id_tiket) }}">
                                                <span class="icon text-white">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif


        @if ($jadwal->jenis_kapal == 'Penumpang & Kendaraan')
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('tiketKendaraan.create') }}" class="btn btn-primary btn-icon-split float-right">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Baru</span>
                    </a>
                </div>

            </div>
            <div class="my-2"></div>
        @endif

        @if ($jadwal->jenis_kapal == 'Kendaraan' || $jadwal->jenis_kapal == 'Penumpang & Kendaraan')
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Tiket Kendaraan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kendaraan</th>
                                    <th>Total Tiket</th>
                                    <th>Jumlah Tiket Tersisa</th>
                                    <th>Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kendaraan</th>
                                    <th>Total Tiket</th>
                                    <th>Jumlah Tiket Tersisa</th>
                                    <th>Harga</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($kendaraan as $d)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$d->jenis_kendaraan}}</td>
                                    <td>{{$d->jumlah_tiket}}</td>
                                    <td>{{$d->sisa_tiket}}</td>
                                    <td>{{$d->harga}}</td>


                                    <td>
                                        <a href="{{ route('tiketKendaraan.edit', $d->id_tiket_kendaraan) }}" class="btn btn-info">
                                            <span class="icon text-white">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                        <a href="#" class="btn btn-danger deleteButton" data="{{ route('tiketKendaraan.destroy', $d->id_tiket_kendaraan) }}">
                                            <span class="icon text-white">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif


    </div>

@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.3/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            var timestamp = '{{ Session::get('success') }}';
            if (timestamp) {
                Swal.fire(
                    'Tersimpan !',
                    timestamp,
                    'success'
                )
            }

        });

        $(".deleteButton").on('click', function() {
            var z = $(this).attr('data');
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus data ?',
                text: "Data yang terhapus tidak akan bisa dikembalikan !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        url: z,
                        success: function(res) {
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Sukses Terhapus!",
                                type: "success",
                                icon: "success",
                            }).then((result) => {
                                // Reload the Page
                                location.reload();
                            });

                        }
                    });


                }
            })


        });
    </script>

@endsection
