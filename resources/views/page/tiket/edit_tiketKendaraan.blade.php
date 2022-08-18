@extends('master')
@section('css')
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ubah Tiket Kendaraan</h1>
        </div>


        <div class="row">

            <div class="col-lg-12">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Ubah</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('tiketKendaraan.update', $get->id_tiket_kendaraan) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" value="{{ Session::get('jadwal') }}" name="id_jadwal">
                            <div class="form-group">
                                <label>Jenis Kendaraan</label>
                                <select class="form-control" name="jenis_kendaraan">
                                    <option hidden>Pilih Jenis Kendaraan</option>
                                    <option value="Sepeda Motor 2.A (s.d 249CC)"
                                        {{ $get->jenis_kendaraan == 'Sepeda Motor 2.A (s.d 249CC)' ? 'selected' : '' }}>
                                        Sepeda Motor 2.A (s.d
                                        249CC)</option>
                                    <option value="Truk Sedang 4.B (Kosong)"
                                        {{ $get->jenis_kendaraan == 'Truk Sedang 4.B (Kosong)' ? 'selected' : '' }}>Truk
                                        Sedang 4.B (Kosong)
                                    </option>
                                    <option value="Truk Sedang 4.B"
                                        {{ $get->jenis_kendaraan == 'Truk Sedang 4.B' ? 'selected' : '' }}>Truk Sedang 4.B
                                    </option>
                                    <option value="Kend. Kecil 3.A (s.d 2000CC)"
                                        {{ $get->jenis_kendaraan == 'Kend. Kecil 3.A (s.d 2000CC)' ? 'selected' : '' }}>
                                        Kend. Kecil 3.A (s.d
                                        2000CC)</option>
                                    <option value="Kend. Kecil 3.B (2001CC ke Atas)"
                                        {{ $get->jenis_kendaraan == 'Kend. Kecil 3.B (2001CC ke Atas)' ? 'selected' : '' }}>
                                        Kend. Kecil 3.B
                                        (2001CC ke Atas)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Tiket</label>
                                <input type="number" class="form-control" name="jumlah_tiket" placeholder="" value="{{$get->jumlah_tiket}}">
                            </div>
                            <div class="form-group">
                                <label>Harga Tiket</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" name="harga" class="form-control"
                                        aria-describedby="basic-addon1" value="{{$get->harga}}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">

                                <span class="text">Update</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
