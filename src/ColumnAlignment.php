<?php


namespace Lab36\ExcelReport;


use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

trait ColumnAlignment
{
    /**
     * @var array
     */
    private $cell_alignment = [
        'HORIZONTAL_GENERAL' => Alignment::HORIZONTAL_GENERAL,
        'HORIZONTAL_LEFT' => Alignment::HORIZONTAL_LEFT,
        'HORIZONTAL_RIGHT' => Alignment::HORIZONTAL_RIGHT,
        'HORIZONTAL_CENTER' => Alignment::HORIZONTAL_CENTER,
        'HORIZONTAL_CENTER_CONTINUOUS' => Alignment::HORIZONTAL_CENTER_CONTINUOUS,
        'HORIZONTAL_JUSTIFY' => Alignment::HORIZONTAL_JUSTIFY,
        'HORIZONTAL_FILL' => Alignment::HORIZONTAL_FILL,
        'HORIZONTAL_DISTRIBUTED' => Alignment::HORIZONTAL_DISTRIBUTED,
        'LEFT' => Alignment::HORIZONTAL_LEFT,
        'RIGHT' => Alignment::HORIZONTAL_RIGHT,
        'CENTER' => Alignment::HORIZONTAL_CENTER,
    ];


    public function columnAlignment(): array
    {
        return [];
    }

}
