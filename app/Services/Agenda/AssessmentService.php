<?php

namespace App\Services\Agenda;

use App\Models\Agenda\AssessmentRecord;
use Illuminate\Support\Str;

class AssessmentService
{
    public function storeAssessment($request, $evaluator)
    {
        $aspects = json_decode($request->aspects, true);
        $data = [];

        foreach ($aspects as $item) {
            if ($item['name'] != 'note') {
                $data[] = [
                    'id' => Str::uuid(),
                    'periode_id' => $request->periode_id,
                    'siswa_user_id' => $request->siswa_user_id,
                    'aspect_id' => $item['name'],
                    'is_note' => false,
                    'answer' => $item['value'],
                    'bulan' => $request->bulan,
                    'minggu_ke' => $request->minggu_ke,
                    'evaluator' => $evaluator,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {
                $data[] = [
                    'id' => Str::uuid(),
                    'periode_id' => $request->periode_id,
                    'siswa_user_id' => $request->siswa_user_id,
                    'aspect_id' => null,
                    'is_note' => true,
                    'answer' => $item['value'],
                    'bulan' => $request->bulan,
                    'minggu_ke' => $request->minggu_ke,
                    'evaluator' => 'Teacher',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($data, 10) as $dt) {
            $query = AssessmentRecord::insert($dt);
        }

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function checkExist($request, $evaluator)
    {
        return AssessmentRecord::where('periode_id', $request->periode_id)
            ->where('siswa_user_id', $request->siswa_user_id)
            ->where('bulan', $request->bulan)
            ->where('minggu_ke', $request->minggu_ke)
            ->where('evaluator', $evaluator)
            ->exists();
    }

    public function getNoteAssessment($request)
    {
        $assessmentData = AssessmentRecord::with('aspect')
            ->where('siswa_user_id', $request[0]['siswa_user_id'])
            ->where('periode_id', $request[0]['periode_id'])
            ->where('bulan', $request[0]['bulan'])
            ->where('minggu_ke', $request[0]['minggu_ke'])
            ->where('evaluator', $request[0]['evaluator'])
            ->where('is_note', true)
            ->first();

        return $assessmentData;
    }
}
