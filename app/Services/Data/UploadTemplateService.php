<?php

namespace App\Services\Data;

use App\Jobs\UploadDataSiswaJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadTemplateService
{
    public function storeData($filetmp)
    {
        $reader = IOFactory::createReaderForFile($filetmp);
        $spreadsheet = $reader->load($filetmp);
        $activeWorksheet = $spreadsheet->getActiveSheet()->toArray();

        $data = [];
        for ($row = 8; $row < count($activeWorksheet); $row++) {
            $data[] = [
                'nama' => $activeWorksheet[$row][3],
                'username' => $activeWorksheet[$row][1],
                'gender' => $activeWorksheet[$row][4],
                'password' => '123456',
                'nis' => $activeWorksheet[$row][1],
                'nisn' => $activeWorksheet[$row][2] ? $activeWorksheet[$row][2] : null,
            ];
        }

        $chunks = array_chunk($data, 200);
        $total = count($data);

        DB::beginTransaction();

        try {
            foreach ($chunks as $chunk) {
                UploadDataSiswaJob::dispatch($chunk, $total);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Semua proses gagal.', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
