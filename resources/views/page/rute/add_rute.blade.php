@extends('master')


@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Rute</h1>
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
                        <form method="POST" action="{{ route('rute.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>Rute Awal</label>
                                <input type="text" class="form-control" name="rute_awal" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Rute Akhir</label>
                                <input type="text" class="form-control" name="rute_akhir" placeholder="">
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
