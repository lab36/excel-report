<?php


namespace Lab36\ExcelReport\Tests;


use Lab36\ExcelReport\ExcelReport;

class ProjectDetailsExcelReport extends ExcelReport
{
    public function columnMappings(): array
    {
        return [
            'project' => __('Project name'),
            'start_date' => 'Project date',
            'cost' => 'Cost',
            'type' => 'Type',
            'state'=> 'State',
            'client_name'=>'Client name',
            'client_address'=>'Client address',
        ];
    }
}
