<?php

namespace App\Exports;

use Carbon\Carbon;
/* From array */
use Maatwebsite\Excel\Concerns\FromArray;
/* Heading */
use Maatwebsite\Excel\Concerns\WithHeadings;
/* Value binders */
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
/* Auto size column */
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
/* Styling */
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
/* Drawing */
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
/* Background */
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ResumenExport extends DefaultValueBinder implements FromArray, WithHeadings, WithCustomValueBinder, ShouldAutoSize, WithStyles, WithColumnWidths, WithDrawings
{
    protected $invoices, $area, $user, $week, $time;

    public function __construct(array $invoices, $area, $user, $week, $time)
    {
        $this->invoices = $invoices;
        $this->area = $area;
        $this->user = $user;
        $this->week = $week;
        $this->time = $time;
    }

    public function array(): array
    {
        return $this->invoices;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 7,
            'B' => 7,
            'C' => 7,
            'D' => 30,
            'E' => 30,
            'F' => 30,  
            'G' => 8, 
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setPath(public_path('/images/logo-mph.png'));
        $drawing->setWidth(250);
        $drawing->setCoordinates('A1');
        return $drawing;
    }

    public function headings(): array
    {
        return [
            ['REGISTRO DE ACTIVIDADES'],
            [],[],[],
            ['UNIDAD ORGÁNICA', '', '', $this->area],
            ['APELLIDOS Y NOMBRES', '', '', $this->user],
            ['SEMANA', '', '', $this->week],
            ['TOTAL HORAS', '', '', $this->time],
            [],
            ['FECHA','INICIO','TIEMPO','PROYECTO','ACTIVIDAD','TAREA','TERMINO'],
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);
            return true;
        }
        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setShowGridlines(false);
        $sheet->mergeCells('A1:G3');
        $sheet->mergeCells('A5:C5');
        $sheet->mergeCells('A6:C6');
        $sheet->mergeCells('A7:C7');
        $sheet->mergeCells('A8:C8');
        $sheet->mergeCells('D5:E5');
        $sheet->mergeCells('D6:E6');
        $sheet->mergeCells('D7:E7');
        $sheet->mergeCells('D8:E8');
        return [
            'A:G' => [
                'font' => ['size' => 9], 
                'alignment' => ['vertical' => 'center','wrapText' => true]
            ],
            'A5:E8' => [
                'font' => ['bold' => true], 
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ],
            'D5:D8' => [
                'font' => ['bold' => true, 'color' => ['argb' => '0DC7E0']], 
            ],
            'A10:G100' => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ],
            'A:C' => [
                'alignment' => ['horizontal' => 'center']
            ],
            'G' => [
                'alignment' => ['horizontal' => 'center']
            ],
            '10' => [
                'font' => ['bold' => true], 
                'fill' => ['fillType' => Fill::FILL_SOLID,'color' => ['argb' => '0DC7E0']], 
                'alignment' => ['horizontal' => 'center']
            ],
            '1' => [
                'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => '0DC7E0']], 
            ],
        ];
    }
}