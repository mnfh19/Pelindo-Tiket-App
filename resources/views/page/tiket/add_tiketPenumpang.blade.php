@extends('master')
@section('css')
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Tiket Penumpang</h1>
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
                        <h6 class="m-0 font-weight-bold text-primary">Form Tambah</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('tiketPenumpang.store') }}">
                            @csrf
                            <input type="hidden" value="{{Session::get('jadwal')}}" name="id_jadwal">
                            <div class="form-group">
                                <label>Kelas Tiket</label>
                                <input type="text" class="form-control" name="kelas_tiket" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Jumlah Tiket</label>
                                <input type="number" class="form-control" name="jumlah_tiket" placeholder="">
                            </div>
                            <div class="form-group"">
                                <label>Harga Tiket Balita</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" id="balita" name="harga_balita" class="form-control" aria-label="Balita"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Harga Tiket Dewasa</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" id="dewasa" name="harga_dewasa" class="form-control" aria-label="Dewasa"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">

                                <span class="text">Tambah</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
