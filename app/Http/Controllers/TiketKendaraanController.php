<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TiketKendaraanModel;
use Illuminate\Support\Facades\Session;

class TiketKendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page/tiket/add_tiketKendaraan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_jadwal' => 'required',
            'jenis_kendaraan' => 'required',
            'jumlah_tiket' => 'required',
            'harga' => 'required',
        ]);
        $show = TiketKendaraanModel::create($validatedData);
        $jadwal = Session::get('jadwal');

        return redirect('/tiket/'.$jadwal)->with('success', 'Sukses Tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = TiketKendaraanModel::where('id_tiket_kendaraan', $id)->first();

        return view('page/tiket/edit_tiketKendaraan')->with('get', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        TiketKendaraanModel::where('id_tiket_kendaraan', $id)->update([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'jumlah_tiket' => $request->jumlah_tiket,
            'harga' => $request->harga,
        ]);

        $jadwal = Session::get('jadwal');

        return redirect('/tiket/'.$jadwal)->with('success', 'Sukses Mengubah Data !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TiketKendaraanModel::where('id_tiket_kendaraan', $id)->delete();
        return true;
    }
}
