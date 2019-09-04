<?php

namespace Lab36\ExcelReport;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelReportDefaultTheme implements ExcelThemeInterface
{

    public function apply(Worksheet $active_sheet, int $title_row_no, int $filter_row_no, int $header_row_no, int $no_of_rows, int $no_of_columns)
    {
        $first_data_row = max($title_row_no, $filter_row_no, $header_row_no) + 1;

        $active_sheet->setShowGridLines(false);
        $active_sheet->getRowDimension($title_row_no)->setRowHeight(45);

        $title_style = [
            'font' => [
                'bold' => true,
                'size' => 18,
                'color' => [
                    'argb' => 'FF003366',
                ],
            ],
        ];

        $active_sheet->getStyle('A'.$title_row_no)->applyFromArray($title_style);

        $filter_style = [
            'font' => [
                'bold' => true,
                'size' => 8,
                'color' => [
                    'argb' => 'FF376092',
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFCCCCCC',
                ],
            ],
        ];

        $active_sheet->getStyle('A'.$filter_row_no.':'.Coordinate::stringFromColumnIndex($no_of_columns).$filter_row_no)->applyFromArray($filter_style);

        $active_sheet->getRowDimension($header_row_no)->setRowHeight(30);
        $header_style = [
            'font' => [
                'bold' => true,
                'size' => 10.5,
                'color' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FF2E5394',
                ],
            ],
        ];

        $active_sheet->getStyle('A'.$header_row_no.':'.Coordinate::stringFromColumnIndex($no_of_columns).$header_row_no)->applyFromArray($header_style);

        $active_sheet->getStyle('A'.($title_row_no + 1).':B'.($title_row_no + 1))->applyFromArray(
            [
                'borders' => [
                    'top' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => ['argb' => 'FF003366'],
                    ],
                ],
            ]
        );

        $active_sheet->setCellValue('B'.($title_row_no + 1), Carbon::today()->toDateString());
        $active_sheet->getStyle('B'.($title_row_no + 1))->applyFromArray(
            [
                'font' => [
                    'size' => 10,
                    'color' => [
                        'argb' => 'FF777777',
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    'vertical' => Alignment::VERTICAL_TOP,
                ],
            ]
        );

        $table_style = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'argb' => 'FFB9B9B9',
                    ],
                ],
            ],
        ];

        $active_sheet->getStyle('A'.($first_data_row).':'.Coordinate::stringFromColumnIndex($no_of_columns).($no_of_rows))->applyFromArray($table_style);

        $column_style = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFF2F2F2',
                ],
            ],
        ];

        for ($i = 1; $i <= $no_of_columns; $i++) {
            if ($i % 2 === 0) {
                $active_sheet->getStyle(Coordinate::stringFromColumnIndex($i).$first_data_row.':'.Coordinate::stringFromColumnIndex($i).($no_of_rows))
                             ->applyFromArray($column_style);
            }
        }
    }


    public function applyRowStyle(Worksheet $active_sheet, int $row, array $row_data)
    {
        if (config('excel-report.default_row_height')) {
            $active_sheet->getDefaultRowDimension(Coordinate::stringFromColumnIndex($row))->setRowHeight(config('excel-report.default_row_height'));
        }
    }


    public function applyCellStyle(Worksheet $active_sheet, int $row, int $column, $value)
    {
        // TODO: Implement applyCellStyle() method.
    }

}
