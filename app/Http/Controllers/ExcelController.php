<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class ExcelController extends Controller
{
    public function saleExcel($from,$to)
    {
        $users = User::with(['sales' => function($query) {
            $query->where('estado', 'Ejecutado');
        }])->whereHas('sales', function(Builder $q)use($from,$to) {
            $q->where('estado', 'Ejecutado')
                ->when($from, fn($q, $start) => $q->whereDate('updated_at', '>=', $start))
                ->when($to, fn($q, $end) => $q->whereDate('updated_at', '<=', $end));
        }, '>=', 1)
        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Agregar una imagen en la parte superior
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo de la Empresa');
        $drawing->setPath(public_path('IMG/log.png')); // Ruta a la imagen
        $drawing->setHeight(50); // Altura de la imagen
        $drawing->setCoordinates('A1'); // Establecer la celda donde se coloca la imagen
        $drawing->setWorksheet($sheet);

        // Títulos de las columnas (desplazado para dejar espacio para la imagen)
        $sheet->setCellValue('A5', '#');
        $sheet->setCellValue('B5', 'Nombre');
        $sheet->setCellValue('C5', 'Nro de ventas');
        $sheet->setCellValue('D5', 'Subtotal');
        $sheet->setCellValue('E5', 'Comisión');
        $sheet->setCellValue('F5', 'Descuento');
        $sheet->setCellValue('G5', 'Transporte');
        $sheet->setCellValue('H5', 'Total');

        // Estilo para los bordes
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,  // Tipo de borde
                    'color' => ['argb' => 'FF000000'],    // Color del borde (negro)
                ],
            ],
        ];

        // Aplicar bordes a las celdas de los títulos
        $sheet->getStyle('A5:H5')->applyFromArray($styleArray);

        $row = 6; // Fila inicial para los datos (después de la imagen)

        // Iterar sobre los usuarios y agregar sus datos
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $row - 5);
            $sheet->setCellValue('B' . $row, $user->full_name);
            $sheet->setCellValue('C' . $row, $user->sales->count());
            $sheet->setCellValue('D' . $row, $user->full_price + $user->sales->sum('comision') + $user->sales->sum('transporte'));
            $sheet->setCellValue('E' . $row, $user->sales->sum('comision'));
            $sheet->setCellValue('F' . $row, number_format($user->sales->pluck('products')->collapse()->sum('pivot.precio') * 0.24, 2));
            $sheet->setCellValue('G' . $row, number_format($user->sales->sum('transporte'), 2));
            $sheet->setCellValue('H' . $row, number_format($user->sales->pluck('products')->collapse()->sum('pivot.precio') * 0.76, 2));

            // Aplicar bordes a cada fila de datos
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray($styleArray);

            $row++;
        }

        // Total en la última fila
        $sheet->setCellValue('G' . $row, 'Total');
        $sheet->setCellValue('H' . $row, number_format($users->sum('full_price') * 0.76 + $users->pluck('sales')->collapse()->sum('overol') * 65, 2));

        // Aplicar bordes a la fila total
        $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray($styleArray);

        // Configurar el tipo de contenido para la descarga
        $writer = new Xlsx($spreadsheet);
        $fileName = 'reporte_ventas.xlsx';
        
        // Forzar la descarga del archivo Excel
        return response()->stream(
            function() use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="reporte_ventas.xlsx"',
            ]
        );

    }
    public function productionExcel($from,$to){
        $productions = Production::where('estado', 'Concluido')
        ->when($from, fn($q, $start) => $q->whereDate('updated_at', '>=', $start))
        ->when($to, fn($q, $end) => $q->whereDate('updated_at', '<=', $end))
        ->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Agregar una imagen en la parte superior (ocupando 4 filas)
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo de la Empresa');
    $drawing->setPath(public_path('IMG/log.png')); // Ruta a la imagen
    $drawing->setHeight(50); // Altura de la imagen para cubrir 4 filas
    $drawing->setCoordinates('A1'); // Establecer la celda donde se coloca la imagen
    $drawing->setWorksheet($sheet);

    // Títulos de las columnas (desplazado para dejar espacio para la imagen)
    $sheet->setCellValue('A5', '#');
    $sheet->setCellValue('B5', 'Fecha');
    $sheet->setCellValue('C5', 'Nombre');
    $sheet->setCellValue('D5', 'Ayudantes');
    $sheet->setCellValue('E5', 'Productos producidos');
    $sheet->setCellValue('F5', 'Cantidad de materiales');

    // Estilo para los bordes
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,  // Tipo de borde
                'color' => ['argb' => 'FF000000'],    // Color del borde (negro)
            ],
        ],
    ];

    // Aplicar bordes a las celdas de los títulos
    $sheet->getStyle('A5:F5')->applyFromArray($styleArray);

    $row = 6; // Fila inicial para los datos (después de la imagen y los títulos)

    // Iterar sobre las producciones y agregar sus datos
    foreach ($productions as $production) {
        $sheet->setCellValue('A' . $row, $row - 5);
        $sheet->setCellValue('B' . $row, $production->updated_at->format('d-m-Y'));
        $sheet->setCellValue('C' . $row, $production->user->full_name);

        // Lista de ayudantes
        $helpers = [];
        foreach ($production->users as $user) {
            $helpers[] = $user->full_name . ' - ' . $user->pivot->hour;
        }
        $sheet->setCellValue('D' . $row, implode("\n", $helpers));

        // Lista de productos producidos
        $products = [];
        foreach ($production->products as $product) {
            $products[] = $product->nombre . ' = ' . $product->pivot->cantidad;
        }
        $sheet->setCellValue('E' . $row, implode("\n", $products));

        $sheet->setCellValue('F' . $row, $production->cantidad . ' Kg.');

        // Aplicar bordes a cada fila de datos
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);

        $row++;
    }

    // Total en la última fila
    $sheet->setCellValue('E' . $row, 'Total');
    $sheet->setCellValue('F' . $row, $productions->sum('cantidad') . ' Kg.');

    // Aplicar bordes a la fila total
    $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);

    // Configurar el tipo de contenido para la descarga
    $writer = new Xlsx($spreadsheet);
    $fileName = 'reporte_producciones.xlsx';
    
    // Forzar la descarga del archivo Excel
    return response()->stream(
        function() use ($writer) {
            $writer->save('php://output');
        },
        200,
        [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="reporte_producciones.xlsx"',
        ]
    );
    }
}
