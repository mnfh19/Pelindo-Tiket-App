<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BookingModel;
use App\TiketModel;
use App\TiketKendaraanModel;
use App\PenumpangModel;
use App\JadwalModel;
use App\KapalModel;
use App\RuteModel;
use App\QTiketModel;
use App\GraphModel;
use App\UserModel;
use JsonException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanController extends Controller
{
    function dashboard(Request $request){

        if($request->session()->has('username')){

            $now = Carbon::now();
            $hariini = BookingModel::get();

            // //Card
            $today = 0;
            $monthly = 0;
            $bayar = 0;
            foreach ($hariini as $d) {
                $dt = Carbon::parse($d->tgl_booking);
                $tgl = $dt->toDateString();
                $bln = $dt->format('m');
                if ($tgl == $now->toDateString()) {
                    $today += $d->harga_total;
                }

                if ($bln == $now->month) {
                    $monthly +=  $d->harga_total;
                }

                if ($d->status_booking == 1) {
                    $bayar++;
                }



            }


            // line Graph
            $bookPerBulan = BookingModel::select('id_booking', 'tgl_booking')
                            ->get()
                            ->groupBy(function ($date) {
                                return Carbon::parse($date->tgl_booking)->format('m');
                            });

            $usermcount = [];
            $userArr = [];

            foreach ($bookPerBulan as $key => $value) {
                $usermcount[(int)$key] = count($value);
            }

            for ($i = 1; $i <= 12; $i++) {
                if (!empty($usermcount[$i])) {
                    $dat = GraphModel::where('month',$i)->first();
                    $userArr[] = $dat->total;
                } else {
                    $userArr[] = 0;
                }
            }

            $data['bayar'] = $bayar;
            $data['monthly'] = $monthly;
            $data['today'] = $today;
            $data['line_graph'] = $userArr;

            return view('page/dashboard', $data);


		}else{
			return redirect('/login');
		}





        //PIE Graph
        // $booking= BookingModel::all();
        // $kapal = KapalModel::get();



        // foreach ($kapal as $d) {
        //     $tiketP['penumpang'][$d->id_kapal] = 0;
        // }



        // foreach ($booking as $d) {
        //     if ($d->penumpang_dewasa != 0) {

        //         $tiket = QTiketModel::where('id_tiket', $d->id_tiket)->get();
        //         foreach ($tiket as $e) {
        //             $tot = BookingModel::where('id_tiket', $e->id_tiket)->get();
        //             $total = 0;
        //             foreach ($tot as $f) {
        //                 $total += $f->penumpang_balita + $f->penumpang_dewasa;
        //             }
        //             echo $e->id_tiket." terjual ".$total."</br>";
        //             $tiketP['penumpang'][$e->id_kapal] = $total;

        //         }
        //     }

        //     if ($d->id_tiket_kendaraan != 0) {

        //         $tiket = QTiketModel::where('id_tiket', $d->id_tiket)->get();
        //         foreach ($tiket as $e) {
        //             $tot = BookingModel::where('id_tiket', $e->id_tiket)->get();
        //             $total = 0;
        //             foreach ($tot as $f) {
        //                 $total += $f->penumpang_balita + $f->penumpang_dewasa;
        //             }
        //             echo $e->id_tiket." terjual ".$total."</br>";
        //             $tiketP['penumpang'][$e->id_kapal] = $total;

        //         }
        //     }
        // }





        // echo json_encode($monthly);


    }

    public function index()
    {

        $data['booking'] = BookingModel::get();
        foreach ($data['booking'] as $d) {



            if ($d->id_tiket != 0) {
                $data['tiket'][$d->id_booking] = TiketModel::where('id_tiket', $d->id_tiket)->first();
                $data['jadwal'][$d->id_booking] = JadwalModel::where('id_jadwal', $data['tiket'][$d->id_booking]->id_jadwal)->first();
                $data['kapal'][$d->id_booking] = KapalModel::where('id_kapal', $data['jadwal'][$d->id_booking]->id_kapal)->first();
                $data['rute'][$d->id_booking] = RuteModel::where('id_rute', $data['kapal'][$d->id_booking]->id_rute)->first();

                $data['booking']->kelas_tiket = $data['tiket'][$d->id_booking]->kelas_tiket;
            }else {
                $data['tiket'][$d->id_booking] = new TiketModel();
                $data['tiket'][$d->id_booking]->kelas_tiket = "-";

            }

            if ($d->id_tiket_kendaraan != 0) {
                $data['tiket_kendaraan'][$d->id_booking] = TiketKendaraanModel::where('id_tiket_kendaraan', $d->id_tiket_kendaraan)->first();
                $data['jadwal'][$d->id_booking] = JadwalModel::where('id_jadwal', $data['tiket_kendaraan'][$d->id_booking]->id_jadwal)->first();
                $data['kapal'][$d->id_booking] = KapalModel::where('id_kapal', $data['jadwal'][$d->id_booking]->id_kapal)->first();
                $data['rute'][$d->id_booking] = RuteModel::where('id_rute', $data['kapal'][$d->id_booking]->id_rute)->first();
            }else {
                $data['tiket_kendaraan'][$d->id_booking] = new TiketModel();
                $data['tiket_kendaraan'][$d->id_booking]->jenis_kendaraan = "-";
                // $penumpang = 0;
            }

            $penumpang = PenumpangModel::where('id_booking', $d->id_booking)->get();
            if ($penumpang->isEmpty()) {
                $data['penumpang'][$d->id_booking] = "Kosong";
            }else {
                $data['penumpang'][$d->id_booking] = $penumpang;
            }
        }

        $data['jalan'] = RuteModel::get();

        return view('page/laporan/laporan', $data);
        // echo json_encode($data['tiket'][1]);
    }

    public function cetakTiket($id){
        $pen = PenumpangModel::where('no_tiket',$id)->first();


        $get = BookingModel::where('id_booking', $pen->id_booking)->first();

        $user = UserModel::where('id_user',$get->id_user)->first();



        if($get->id_tiket != 0){
            $pick = BookingModel::select('booking.*', 'jadwal.*', 'tiket.*', 'kapal.*', 'rute.*',)
                                    ->join('tiket', 'booking.id_tiket', '=', 'tiket.id_tiket')
                                    ->join('jadwal', 'tiket.id_jadwal', '=', 'jadwal.id_jadwal')
                                    ->join('kapal', 'jadwal.id_kapal', '=', 'kapal.id_kapal')
                                    ->join('rute', 'kapal.id_rute', '=', 'rute.id_rute')
                                    ->where('id_booking', $get->id_booking)->first();
        }

        if($get->id_tiket_kendaraan != 0){
            $pick = BookingModel::select('booking.*', 'jadwal.*', 'tiket_kendaraan.*', 'kapal.*', 'rute.*',)
                                    ->join('tiket_kendaraan', 'booking.id_tiket_kendaraan', '=', 'tiket_kendaraan.id_tiket_kendaraan')
                                    ->join('jadwal', 'tiket_kendaraan.id_jadwal', '=', 'jadwal.id_jadwal')
                                    ->join('kapal', 'jadwal.id_kapal', '=', 'kapal.id_kapal')
                                    ->join('rute', 'kapal.id_rute', '=', 'rute.id_rute')
                                    ->where('id_booking', $get->id_booking)->first();
        }

        if($get->id_tiket != 0 &&$get->id_tiket_kendaraan != 0){
            $pick = BookingModel::select('booking.*', 'jadwal.*', 'tiket.*', 'kapal.*', 'rute.*', 'tiket_kendaraan.*',)
                                    ->join('tiket', 'booking.id_tiket', '=', 'tiket.id_tiket')
                                    ->join('tiket_kendaraan', 'booking.id_tiket_kendaraan', '=', 'tiket_kendaraan.id_tiket_kendaraan')
                                    ->join('jadwal', 'tiket.id_jadwal', '=', 'jadwal.id_jadwal')
                                    ->join('kapal', 'jadwal.id_kapal', '=', 'kapal.id_kapal')
                                    ->join('rute', 'kapal.id_rute', '=', 'rute.id_rute')
                                    ->where('id_booking', $get->id_booking)->first();
        }


        $pdf = PDF::loadview('print/tiket',['p'=>$pen, 'b'=>$pick, 'u'=>$user, ]);
        return $pdf->stream('tiket.pdf');

        // $data['penumpang'] = $pen;
        // return view('print/tiket', $data);
    }

    public function cetakin(){

        return view('print/cetakin');
    }
}
