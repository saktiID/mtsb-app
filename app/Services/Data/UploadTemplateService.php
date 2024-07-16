<?php

namespace App\Services\Data;

use App\Jobs\UploadDataSiswaJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                'email' => null,
                'telp' => null,
            ];
        }

        $query = DB::transaction(function () use ($data) {
            $uploader = UploadDataSiswaJob::dispatch($data);

            return $uploader;
        });

        if ($query) {
            return true;
        } else {
            DB::rollBack();

            return false;
        }
    }
}
