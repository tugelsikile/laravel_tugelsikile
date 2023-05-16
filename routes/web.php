<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('rumah-sakit.manage'); })->middleware('auth');
Route::get('/login', function () { return view('login'); })->name('login');
Route::get('/logout', function () {
    auth()->logout();
    return response()->json(['message' => 'ok'],200);
})->name('logout');
Route::post('/login-submit', function (\Illuminate\Http\Request  $request) {
    try {
        $valid = \Illuminate\Support\Facades\Validator::make($request->all(),[
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string|min:3'
        ]);
        if ($valid->fails()) throw new Exception(collect($valid->errors()->all())->join("\n"),400);
        $user = \App\Models\User::where('username', $request->username)->first();
        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) throw new Exception("Invalid username or password",400);
        auth()->login($user);
        return response()->json(['message' => 'success login', 'data' => $user],200);
    } catch (Exception $exception) {
        return response()->json(['message' => $exception->getMessage()], $exception->getCode());
    }
});
Route::group(['prefix' => 'rumah-sakit', 'middleware' => 'auth'], function () {
    Route::get('/', function () { return view('rumah-sakit.manage'); });
    Route::post('/table', function () {
        return response()->json(['data' => \App\Models\RumahSakit::all()],200);
    });
    Route::put('/create', function (\Illuminate\Http\Request $request){
        try {
            $valid = \Illuminate\Support\Facades\Validator::make($request->all(),[
                'nama_rumah_sakit' => 'required|string|min:3|max:199',
                'alamat_rumah_sakit' => 'required|string|min:3',
                'nomor_telepon' => 'required',
                'email' => 'required|email',
            ]);
            if ($valid->fails()) throw new Exception(collect($valid->errors()->all())->join("\n"),400);
            $rumkit = new \App\Models\RumahSakit();
            $rumkit->name = $request->nama_rumah_sakit;
            $rumkit->code = \Illuminate\Support\Str::random(5);
            $rumkit->address = $request->alamat_rumah_sakit;
            $rumkit->email = $request->email;
            $rumkit->telp = $request->nomor_telepon;
            $rumkit->saveOrFail();
            return  response()->json(['message' => 'Rumah sakit berhasil dibuat', 'data' => $rumkit],200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    });
    Route::patch('/update', function (\Illuminate\Http\Request $request) {
        try {
            $valid = \Illuminate\Support\Facades\Validator::make($request->all(),[
                'id' => 'required|numeric|exists:rumah_sakits,id',
                'nama_rumah_sakit' => 'required|string|min:3|max:199',
                'alamat_rumah_sakit' => 'required|string|min:3',
                'nomor_telepon' => 'required',
                'email' => 'required|email',
            ]);
            if ($valid->fails()) throw new Exception(collect($valid->errors()->all())->join("\n"),400);
            $rumkit = \App\Models\RumahSakit::where('id', $request->id)->first();
            $rumkit->name = $request->nama_rumah_sakit;
            $rumkit->address = $request->alamat_rumah_sakit;
            $rumkit->email = $request->email;
            $rumkit->telp = $request->nomor_telepon;
            $rumkit->saveOrFail();
            return  response()->json(['message' => 'Rumah sakit berhasil diubah', 'data' => $rumkit],200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    });
    Route::delete('/delete', function (\Illuminate\Http\Request $request) {
        try {
            $valid = \Illuminate\Support\Facades\Validator::make($request->all(),[
                'id' => 'required|numeric|exists:rumah_sakits,id'
            ]);
            if ($valid->fails()) throw new Exception(collect($valid->errors()->all())->join("\n"),400);
            \App\Models\RumahSakit::where('id', $request->id)->delete();
            return response()->json(['message' => 'Success deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    });
    Route::group(['prefix' => 'pasien'], function () {
        Route::get('/', function () {
            $rumkit = \App\Models\RumahSakit::all();
            return view('rumah-sakit.pasien', compact('rumkit'));
        });
        Route::post('/table', function (\Illuminate\Http\Request $request) {
            $pasien = \App\Models\Pasien::orderBy('created_at', 'asc');
            if (strlen($request->rumkit) > 0) $pasien = $pasien->where('rumah_sakit', $request->rumkit);
            $pasien = $pasien->get();
            return response()->json(['message' => 'ok', 'data' => $pasien ], 200);
        });
        Route::put('/create', function (\Illuminate\Http\Request $request){
            try {
                $valid = \Illuminate\Support\Facades\Validator::make($request->all(),[
                    'nama_rumah_sakit' => 'required|exists:rumah_sakits,id',
                    'nama_pasien' => 'required|string|min:3|max:199',
                    'alamat_pasien' => 'required|string|min:3',
                    'nomor_telepon' => 'required',
                ]);
                if ($valid->fails()) throw new Exception(collect($valid->errors()->all())->join("\n"),400);
                $pasien = new \App\Models\Pasien();
                $pasien->rumah_sakit = $request->nama_rumah_sakit;
                $pasien->name = $request->nama_pasien;
                $pasien->address = $request->alamat_pasien;
                $pasien->telp = $request->nomor_telepon;
                $pasien->saveOrFail();
                return  response()->json(['message' => 'Pasien berhasil dibuat', 'data' => $pasien],200);
            } catch (Exception $exception) {
                return response()->json(['message' => $exception->getMessage()], $exception->getCode());
            }
        });
        Route::patch('/update', function (\Illuminate\Http\Request $request) {
            try {
                $valid = \Illuminate\Support\Facades\Validator::make($request->all(),[
                    'id' => 'required|numeric|exists:pasiens,id',
                    'nama_rumah_sakit' => 'required|exists:rumah_sakits,id',
                    'nama_pasien' => 'required|string|min:3|max:199',
                    'alamat_pasien' => 'required|string|min:3',
                    'nomor_telepon' => 'required',
                ]);
                if ($valid->fails()) throw new Exception(collect($valid->errors()->all())->join("\n"),400);
                $pasien = \App\Models\Pasien::where('id', $request->id)->first();
                $pasien->rumah_sakit = $request->nama_rumah_sakit;
                $pasien->name = $request->nama_pasien;
                $pasien->address = $request->alamat_pasien;
                $pasien->telp = $request->nomor_telepon;
                $pasien->saveOrFail();
                return  response()->json(['message' => 'Pasien berhasil diubah', 'data' => $pasien],200);
            } catch (Exception $exception) {
                return response()->json(['message' => $exception->getMessage()], $exception->getCode());
            }
        });
        Route::delete('/delete', function (\Illuminate\Http\Request $request) {
            try {
                $valid = \Illuminate\Support\Facades\Validator::make($request->all(),[
                    'id' => 'required|numeric|exists:pasiens,id'
                ]);
                if ($valid->fails()) throw new Exception(collect($valid->errors()->all())->join("\n"),400);
                \App\Models\Pasien::where('id', $request->id)->delete();
                return response()->json(['message' => 'Success deleted'], 200);
            } catch (Exception $exception) {
                return response()->json(['message' => $exception->getMessage()], $exception->getCode());
            }
        });
    });
});
