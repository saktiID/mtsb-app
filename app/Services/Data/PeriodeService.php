<?php

namespace App\Services\Data;

use App\Models\Data\Periode;
use Illuminate\Support\Facades\DB;

class PeriodeService
{
    public function tambahPeriode($request)
    {
        $query = DB::transaction(function () use ($request) {
            $periode = new Periode;
            $periode->semester = $request->semester;
            $periode->tahun_ajaran = $request->tahun_pertama.'-'.$request->tahun_kedua;

            if ($periode->save()) {
                return true;
            } else {
                DB::rollBack();

                return false;
            }
        });

        return $query;
    }

    public function activatePeriode($id)
    {
        $currentPeriode = Periode::where('periode_status', true)->first();
        if ($currentPeriode) {
            $currentPeriode->periode_status = false;
            $currentPeriode->save();
        }

        $periode = Periode::find($id);
        if ($periode) {
            $periode->periode_status = true;
            $periode->save();

            return true;
        } else {
            return false;
        }
    }

    public function hapusPeriode($id)
    {
        $periode = Periode::find($id);
        if ($periode) {
            $query = $periode->delete();

            return $query;
        } else {
            return false;
        }
    }
}
