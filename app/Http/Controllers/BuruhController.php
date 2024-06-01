<?php

namespace App\Http\Controllers;

use App\Models\BuruhModel;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class BuruhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buruhs = BuruhModel::paginate(10);
        return view('pegawai', compact('buruhs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required',
        ], [
            'required' => ':attribute wajib diisi!'
        ]);
        try {
            BuruhModel::create([
                'id' => Uuid::uuid4()->toString(),
                'name' => $request->nama_pegawai
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menambahkan pegawai!'
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal menambahkan pegawai!'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buruh = BuruhModel::find($id);
        return view('detailBuruh', compact('buruh'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $user = BuruhModel::find($id);
        if ($user) {
            try {
                $user->update([
                    'name' => $request->nama_pegawai
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil mengupdate pegawai!'
                ], 200);
            } catch (\Exception $th) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Gagal mengupdate pegawai!'
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User tidak ditemukan!'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = BuruhModel::find($id);
        if ($pegawai) {
            try {
                $pegawai->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil menghapus pegawai!'
                ], 200);
            } catch (\Exception $th) {
                $pegawai->delete();
                return response()->json([
                    'status' => 500,
                    'message' => 'Gagal menghapus pegawai!'
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Pegawai tidak ditemukan!'
            ], 404);
        }
    }
}
