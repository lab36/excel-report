<?php


namespace Lab36\ExcelReport;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

interface ExcelThemeInterface
{
    public function apply(Worksheet $active_sheet, int $title_row_no, int $filter_row_no, int $header_row_no, int $no_of_rows, int $no_of_columns);


    public function applyRowStyle(Worksheet $active_sheet, int $row, array $row_data);


    public function applyCellStyle(Worksheet $active_sheet, int $row, int $column, $value);
}
