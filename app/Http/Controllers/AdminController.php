<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminModel;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['get'] = AdminModel::orderBy('id_admin', 'DESC')->get();
        return view('page/admin/admin', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page/admin/add_admin');
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
            'username' => 'required|max:255',
            'password' => 'required',
            'level_admin' => 'required|numeric',
            'status_admin' => 'required|numeric',
        ]);
        $show = AdminModel::create($validatedData);

        return redirect('/admin')->with('success', 'Sukses Tersimpan');
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
        $data = AdminModel::where('id_admin', $id)->first();

        return view('page/admin/edit_admin')->with('get', $data);
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
        AdminModel::where('id_admin', $id)->update([
            'username' => $request->username,
            'password' => $request->password,
            'level_admin' => $request->level_admin,
            'status_admin' => $request->status_admin,
        ]);

        return redirect('/admin')->with('success', 'Sukses Mengubah Data !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = AdminModel::findOrFail($id);
        $admin->delete();

        return true;
    }

    public function loginPage(){
        return view('page/admin/login');
    }

    public function loginAdmin(Request $request){
        $user = AdminModel::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors([
                'error' => 'Username belum terdaftar',
            ]);
        }else {
            if ($user->status_admin == 0) {
                return back()->withErrors([
                    'error' => 'User Belum Aktif',
                ]);
            }

            if ($request->pass != $user->password) {
                return back()->withErrors([
                    'error' => 'Password Salah',
                ]);
            }else {
                $request->session()->put('username', $user->username);
                $request->session()->put('level', $user->level_admin);

                return redirect('/');
            }
        }
    }

    function logout(){
        session_unset();
        Session::flush();
        return redirect('/');
    }



}
