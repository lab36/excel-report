<?php


namespace Lab36\ExcelReport\Tests;


use Lab36\ExcelReport\ExcelReport;

class FakeExcelReport extends ExcelReport
{

    public function column_mappings(): array
    {
        return [
            'name' => 'Employee name',
            'start_date' => 'Start date',
            'employee_cost' => 'Employee cost',
        ];
    }


    public function column_formats(): array
    {
        return [
            'employee_name' => 'TEXT',
            'start_date' => 'DATE_YYYY-MM-DD',
            'employee_cost' => 'NUMERIC_FORMATTED',
        ];
    }


    public function column_alignment(): array
    {
        return [
            'employee_name' => 'LEFT',
            'employee_cost' => 'RIGHT',
        ];
    }

}
