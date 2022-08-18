<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TiketModel;
use Illuminate\Support\Facades\Session;

class TiketPenumpangController extends Controller
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
        return view('page/tiket/add_tiketPenumpang');
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
            'kelas_tiket' => 'required',
            'jumlah_tiket' => 'required',
            'harga_balita' => 'required',
            'harga_dewasa' => 'required',
        ]);
        $show = TiketModel::create($validatedData);
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
        $data = TiketModel::where('id_tiket', $id)->first();

        return view('page/tiket/edit_tiketPenumpang')->with('get', $data);
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
        TiketModel::where('id_tiket', $id)->update([
            'kelas_tiket' => $request->kelas_tiket,
            'jumlah_tiket' => $request->jumlah_tiket,
            'harga_balita' => $request->harga_balita,
            'harga_dewasa' => $request->harga_dewasa,
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
        TiketModel::where('id_tiket', $id)->delete();
        return true;
    }
}
