<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Models\Publication;
use App\Http\Requests\TextRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TextController extends Controller
{
    /**
     * Muestra una lista de los mensajes recibidos.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'desc');
        $subjectSort = $request->input('subject_sort', null);

        $query = Text::where('receiver_id', Auth::id())
            ->with('sender');

        if ($subjectSort) {
            $query->orderBy('subject', $subjectSort);
        } else {
            $query->orderBy('created_at', $sort);
        }

        $messages = $query->simplePaginate(9);

        return view('texts.index', compact('messages', 'sort', 'subjectSort'));
    }

    /**
     * Muestra el formulario de contacto.
     */
    public function create(Request $request)
    {
        $publication_id = $request->query('publication_id');
        $publication = Publication::findOrFail($publication_id);
        $receiver_id = $publication->user_id;
        $creator_username = $publication->user->username;
        $phone = Auth::user()->phone;

        return view('texts.create', compact('receiver_id', 'phone', 'creator_username'));
    }

    /**
     * Almacena un nuevo mensaje en la base de datos.
     */
    public function store(TextRequest $request)
    {
        Text::create([
            'emitter_id' => Auth::id(),
            'receiver_id' => $request->input('receiver_id'),
            'subject' => $request->input('subject'),
            'short_description' => $request->input('short_description'),
        ]);

        return back()->with('success', 'Mensaje enviado correctamente.');
    }

    /**
     * Elimina un mensaje específico.
     */
    public function destroy($id)
    {
        $text = Text::findOrFail($id);
        $text->delete();
        return redirect()->route('texts.index')->with('success', 'Mensaje eliminado correctamente.');
    }

    public function unreadCount()
    {
        $unreadCount = Text::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
        return response()->json(['unread_count' => $unreadCount]);
    }

    public function toggleRead(Request $request, $id)
    {
        $message = Text::findOrFail($id);
        $message->is_read = !$message->is_read;
        $message->save();

        return response()->json(['success' => true]);
    }

    public function exportToExcel()
    {
        $messages = Text::where('receiver_id', Auth::id())->with('sender')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add header
        $headers = ['De', 'Teléfono', 'Asunto', 'Descripción breve', 'Fecha'];
        foreach ($headers as $col => $text) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $text);
        }

        // Add data
        $row = 2;
        foreach ($messages as $message) {
            $sheet->setCellValue('A' . $row, $message->sender->username);
            $sheet->setCellValue('B' . $row, $message->sender->phone);
            $sheet->setCellValue('C' . $row, $message->subject);
            $sheet->setCellValue('D' . $row, $message->short_description);
            $sheet->setCellValue('E' . $row, $message->created_at->format('d-m-Y H:i'));
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
        $filename = 'messages.xlsx';
        $writer->save(storage_path('app/public/' . $filename));

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }
}
