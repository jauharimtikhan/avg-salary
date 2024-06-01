<?php

namespace App\Http\Controllers;

use App\Models\BuruhModel;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function calculate(Request $request)
    {
        $total_percentage = array_sum($request->percentages);

        if ($total_percentage != 100) {
            return back()->with('error', 'Total presentase harus 100%');
        }
        if ($request->total_pembayaran == null) {
            return back()->with('error', 'Nominal pembayaran harus diisi');
        }

        foreach ($request->names as $key => $name) {
            $percentage = intval($request->percentages[$key]);
            $total_pembayaran = preg_replace('/[^0-9]/', '', $request->total_pembayaran);
            $amount = (intval($total_pembayaran) * $percentage) / 100;
            BuruhModel::where('name', $name)->update([
                'salary' => $amount
            ]);
        }
        return back()->with('success', 'Berhasil Menyimpan Data Gaji Buruh');
    }
}
