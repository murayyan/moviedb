<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Users;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        //QUERY UNTUK MENGAMBIL DATA DARI TABLE USERS DAN DI-LOAD 10 DATA PER HALAMAN
        $users = Users::orderBy('created_at', 'desc')->get();
        //KEMBALIKAN RESPONSE BERUPA JSON DENGAN FORMAT
        //STATUS = SUCCESS
        //DATA = DATA USERS DARI HASIL QUERY
        $result = [
            'status' => 'success',
            'results' => $users
        ];
        return response()->json($result);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        //SIMPAN DATA USER KE DALAM TABLE USERS MENGGUNAKAN MODEL USER
        $register = Users::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => app('hash')->make($request->password), //PASSWORDNYA KITA ENCRYPT
            'api_token' => Str::random(40)
            // 'api_token' => 'test', //BAGIAN INI HARUSNYA KOSONG KARENA AKAN TERISI JIKA USER LOGIN
        ]);
        if ($register) {
            # code...
            return response()->json(['status' => 'success', 'message' => 'register succesful']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'register succesful']);
        }
    }

    public function edit(Request $request)
    {
        $user = Users::find($request->get('id'));
        return response()->json(['status' => 'success', 'results' => $user]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required|string|max:20|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:6'
        ]);

        $user = Users::find($id);
        $password = $request->password != '' ? app('hash')->make($request->password) : $user->password;

        $update = $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password //PASSWORDNYA KITA ENCRYPT
            // 'api_token' => 'test', //BAGIAN INI HARUSNYA KOSONG KARENA AKAN TERISI JIKA USER LOGIN
        ]);

        if ($update) {
            # code...
            return response()->json(['status' => 'success', 'message' => 'update succesful']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'update succesful']);
        }
    }

    public function destroy($id)
    {
        $user = Users::find($id);
        $delete = $user->delete();

        if ($delete) {
            # code...
            return response()->json(['status' => 'success', 'message' => 'delete succesful']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'delete succesful']);
        }
    }
}
