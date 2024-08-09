<?php

namespace App\Services\Data;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DownloadTemplateService
{
    public function generateTemplateSiswa()
    {
        $judul = 'TEMPLATE UPLOAD SISWA';
        $spreadsheet = new Spreadsheet;
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', $judul);
        $activeWorksheet->mergeCells('A1:E1');
        $activeWorksheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        $activeWorksheet->getStyle('A1')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ],
        ]);

        // Set judul sheet nya
        $activeWorksheet->setTitle('template-upload-siswa');

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border left dengan garis tipis
            ],
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border left dengan garis tipis
            ],
        ];

        // set value A3
        $activeWorksheet->setCellValue('A3', 'Contoh pengisian:');

        // apply style headers contoh
        $activeWorksheet->getStyle('A4')->applyFromArray($style_col);
        $activeWorksheet->getStyle('B4')->applyFromArray($style_col);
        $activeWorksheet->getStyle('C4')->applyFromArray($style_col);
        $activeWorksheet->getStyle('D4')->applyFromArray($style_col);
        $activeWorksheet->getStyle('E4')->applyFromArray($style_col);

        // set value cell headers (untuk contoh input)
        $activeWorksheet->setCellValue('A4', 'NO');
        $activeWorksheet->setCellValue('B4', 'NIS');
        $activeWorksheet->setCellValue('C4', 'NISN');
        $activeWorksheet->setCellValue('D4', 'NAMA');
        $activeWorksheet->setCellValue('E4', 'GENDER');

        // Set width kolom
        $activeWorksheet->getColumnDimension('A')->setWidth(6);
        $activeWorksheet->getColumnDimension('B')->setWidth(30);
        $activeWorksheet->getColumnDimension('C')->setWidth(25);
        $activeWorksheet->getColumnDimension('D')->setWidth(37);
        $activeWorksheet->getColumnDimension('E')->setWidth(10);

        // set value contoh input
        $activeWorksheet->setCellValue('A5', '1');
        $activeWorksheet->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->setCellValue('B5', '121235150056-23-0009');
        $activeWorksheet->setCellValue('C5', '0019888296');
        $activeWorksheet->setCellValue('D5', 'Prilly Latuconsina');
        $activeWorksheet->setCellValue('E5', 'female');

        // apply style di baris tabel pertama
        $activeWorksheet->getStyle('A5')->applyFromArray($style_row);
        $activeWorksheet->getStyle('B5')->applyFromArray($style_row);
        $activeWorksheet->getStyle('C5')->applyFromArray($style_row);
        $activeWorksheet->getStyle('D5')->applyFromArray($style_row);
        $activeWorksheet->getStyle('E5')->applyFromArray($style_row);

        // set value A7
        $activeWorksheet->setCellValue('A7', 'Isi data di tabel berikut:');

        // set value cell headers
        $activeWorksheet->setCellValue('A8', 'NO');
        $activeWorksheet->setCellValue('B8', 'NIS');
        $activeWorksheet->setCellValue('C8', 'NISN');
        $activeWorksheet->setCellValue('D8', 'NAMA');
        $activeWorksheet->setCellValue('E8', 'GENDER');

        // apply style headers
        $activeWorksheet->getStyle('A8')->applyFromArray($style_col);
        $activeWorksheet->getStyle('B8')->applyFromArray($style_col);
        $activeWorksheet->getStyle('C8')->applyFromArray($style_col);
        $activeWorksheet->getStyle('D8')->applyFromArray($style_col);
        $activeWorksheet->getStyle('E8')->applyFromArray($style_col);

        $filename = 'Template upload data siswa';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename='.$filename.'.xls');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }
}
