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
                'nama' => htmlspecialchars($activeWorksheet[$row][3]),
                'username' => htmlspecialchars($activeWorksheet[$row][1]),
                'gender' => htmlspecialchars($activeWorksheet[$row][4]),
                'password' => '123456',
                'nis' => htmlspecialchars($activeWorksheet[$row][1]),
                'nisn' => htmlspecialchars($activeWorksheet[$row][2])
                    ? htmlspecialchars($activeWorksheet[$row][2]) : null,
            ];
        }

        $chunks = array_chunk($data, 100);
        $totalChunks = count($chunks);

        DB::beginTransaction();

        try {
            foreach ($chunks as $index => $chunk) {
                $chunkIndex = $index + 1;
                UploadDataSiswaJob::dispatch($chunk, $totalChunks, $chunkIndex);
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
