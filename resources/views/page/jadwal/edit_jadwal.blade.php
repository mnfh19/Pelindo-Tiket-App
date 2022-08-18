@extends('master')



@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ubah Jadwal</h1>
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
                        <form method="POST" action="{{ route('jadwal.update', $get->id_jadwal) }}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>Pilih Pelayaran</label>
                                <select class="form-control pilihKapal" name="id_kapal">
                                    <option disabled hidden>Pilih Kapal</option>
                                    @foreach ($kapal as $d)
                                        <option value="{{ $d->id_kapal }}" data-jenis="{{ $d->jenis_kapal }}"
                                            {{$get->id_kapal == $d->id_kapal ? "selected" : ""}}>
                                            {{ $d->nama_kapal }} -
                                            {{ $d->KM }} ({{ $d->rute_awal }} ⇆ {{ $d->rute_akhir }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Berangkat</label>
                                <input type="date" class="form-control" name="tgl_berangkat" placeholder="" value="{{$get->tgl_berangkat}}">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Tiba</label>
                                <input type="date" class="form-control" name="tgl_tiba" placeholder="" value="{{$get->tgl_tiba}}">
                            </div>
                            <div class="form-group">
                                <label>Jam Berangkat</label>
                                <input type="time" class="form-control" name="jam_berangkat" placeholder="" value="{{$get->jam_berangkat}}">
                            </div>
                            <div class="form-group">
                                <label>Jam Tiba</label>
                                <input type="time" class="form-control" name="jam_tiba" placeholder="" value="{{$get->jam_tiba}}">
                            </div>
                            <button type="submit" class="btn btn-primary float-right">

                                <span class="text">Ubah</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection


@section('js')
    <script>
        function myFunction() {
            var x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
