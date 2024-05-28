<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publication;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AdminController extends Controller
{
    public function users(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $column = $request->query('column', 'created_at');

        $users = User::orderBy($column, $sort)->simplePaginate(9);

        return view('admin.users', compact('users'));
    }

    public function publications(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $column = $request->query('column', 'created_at');

        $publications = Publication::orderBy($column, $sort)->simplePaginate(9);

        return view('admin.publications', compact('publications'));
    }

    public function reports(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $column = $request->query('column', 'created_at');

        $reportsQuery = User::join('reports', 'users.id', '=', 'reports.user_id')
            ->join('publications', 'publications.id', '=', 'reports.publication_id')
            ->select('reports.*', 'users.username', 'publications.name as publication_name');

        if ($column === 'reason') {
            $reportsQuery->orderByRaw("
                FIELD(reports.reason, 'Contenido inapropiado', 'Información incorrecta', 'Spam', 'Otra razón') $sort
            ");
        } else {
            $reportsQuery->orderBy("reports.$column", $sort);
        }

        $reports = $reportsQuery->simplePaginate(9);

        return view('admin.reports', compact('reports'));
    }

    public function exportUsers()
    {
        $users = User::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add header
        $headers = ['Nombre', 'Email', 'Rol', 'Creado en', 'Actualizado en'];
        foreach ($headers as $col => $text) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $text);
        }

        // Add data
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->username);
            $sheet->setCellValue('B' . $row, $user->email);
            $sheet->setCellValue('C' . $row, $user->role);
            $sheet->setCellValue('D' . $row, $user->created_at->format('d-m-Y H:i'));
            $sheet->setCellValue('E' . $row, $user->updated_at->format('d-m-Y H:i'));
            $row++;
        }

        // Style the header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        // Style the data rows
        $dataStyle = [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A2:E' . ($row - 1))->applyFromArray($dataStyle);

        // Adjust column width
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'users.xlsx';
        $writer->save(storage_path('app/public/' . $filename));

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }

    public function exportPublications()
    {
        $publications = Publication::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add header
        $headers = ['Nombre', 'Usuario', 'Creado en', 'Actualizado en'];
        foreach ($headers as $col => $text) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $text);
        }

        // Add data
        $row = 2;
        foreach ($publications as $publication) {
            $sheet->setCellValue('A' . $row, $publication->name);
            $sheet->setCellValue('B' . $row, $publication->user->username);
            $sheet->setCellValue('C' . $row, $publication->created_at->format('d-m-Y H:i'));
            $sheet->setCellValue('D' . $row, $publication->updated_at->format('d-m-Y H:i'));
            $row++;
        }

        // Style the header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

        // Style the data rows
        $dataStyle = [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A2:D' . ($row - 1))->applyFromArray($dataStyle);

        // Adjust column width
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'publications.xlsx';
        $writer->save(storage_path('app/public/' . $filename));

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }

    public function exportReports()
    {
        $reports = User::join('reports', 'users.id', '=', 'reports.user_id')
            ->join('publications', 'publications.id', '=', 'reports.publication_id')
            ->select('reports.*', 'users.username', 'publications.name as publication_name')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add header
        $headers = ['De', 'Animal', 'Razón', 'Información Adicional', 'Creado en'];
        foreach ($headers as $col => $text) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $text);
        }

        // Add data
        $row = 2;
        foreach ($reports as $report) {
            $sheet->setCellValue('A' . $row, $report->username);
            $sheet->setCellValue('B' . $row, $report->publication_name);
            $sheet->setCellValue('C' . $row, $report->reason);
            $sheet->setCellValue('D' . $row, $report->additional_info);
            $sheet->setCellValue('E' . $row, $report->created_at->format('d-m-Y H:i'));
            $row++;
        }

        // Style the header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        // Style the data rows
        $dataStyle = [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A2:E' . ($row - 1))->applyFromArray($dataStyle);

        // Adjust column width
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'reports.xlsx';
        $writer->save(storage_path('app/public/' . $filename));

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }
}
