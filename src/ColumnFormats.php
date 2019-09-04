<?php


namespace Lab36\ExcelReport;


use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

trait ColumnFormats
{
    /**
     * @var array
     */
    private $cell_formats = [
        'FORMAT_GENERAL' => NumberFormat::FORMAT_GENERAL,
        'FORMAT_TEXT' => NumberFormat::FORMAT_TEXT,
        'FORMAT_NUMBER' => NumberFormat::FORMAT_NUMBER,
        'FORMAT_NUMBER_00' => NumberFormat::FORMAT_NUMBER_00,
        'FORMAT_NUMBER_COMMA_SEPARATED1' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        'FORMAT_NUMBER_COMMA_SEPARATED2' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        'FORMAT_PERCENTAGE' => NumberFormat::FORMAT_PERCENTAGE,
        'FORMAT_PERCENTAGE_00' => NumberFormat::FORMAT_PERCENTAGE_00,
        'FORMAT_DATE_YYYYMMDD2' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
        'FORMAT_DATE_YYYYMMDD' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        'FORMAT_DATE_DDMMYYYY' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'FORMAT_DATE_DMYSLASH' => NumberFormat::FORMAT_DATE_YYYYMMDDSLASH,
        'FORMAT_DATE_DMYMINUS' => NumberFormat::FORMAT_DATE_DMYMINUS,
        'FORMAT_DATE_DMMINUS' => NumberFormat::FORMAT_DATE_DMMINUS,
        'FORMAT_DATE_MYMINUS' => NumberFormat::FORMAT_DATE_MYMINUS,
        'FORMAT_DATE_XLSX14' => NumberFormat::FORMAT_DATE_XLSX14,
        'FORMAT_DATE_XLSX15' => NumberFormat::FORMAT_DATE_XLSX15,
        'FORMAT_DATE_XLSX16' => NumberFormat::FORMAT_DATE_XLSX16,
        'FORMAT_DATE_XLSX17' => NumberFormat::FORMAT_DATE_XLSX17,
        'FORMAT_DATE_XLSX22' => NumberFormat::FORMAT_DATE_XLSX22,
        'FORMAT_DATE_DATETIME' => NumberFormat::FORMAT_DATE_DATETIME,
        'FORMAT_DATE_TIME1' => NumberFormat::FORMAT_DATE_TIME1,
        'FORMAT_DATE_TIME2' => NumberFormat::FORMAT_DATE_TIME2,
        'FORMAT_DATE_TIME3' => NumberFormat::FORMAT_DATE_TIME3,
        'FORMAT_DATE_TIME4' => NumberFormat::FORMAT_DATE_TIME4,
        'FORMAT_DATE_TIME5' => NumberFormat::FORMAT_DATE_TIME5,
        'FORMAT_DATE_TIME6' => NumberFormat::FORMAT_DATE_TIME6,
        'FORMAT_DATE_TIME7' => NumberFormat::FORMAT_DATE_TIME7,
        'FORMAT_DATE_TIME8' => NumberFormat::FORMAT_DATE_TIME8,
        'FORMAT_DATE_YYYYMMDDSLASH' => NumberFormat::FORMAT_DATE_YYYYMMDDSLASH,
        'FORMAT_CURRENCY_USD_SIMPLE' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        'FORMAT_CURRENCY_USD' => NumberFormat::FORMAT_CURRENCY_USD,
        'FORMAT_CURRENCY_EUR_SIMPLE' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        'FORMAT_CURRENCY_EUR' => NumberFormat::FORMAT_CURRENCY_EUR,
        'NUMERIC' => NumberFormat::FORMAT_NUMBER,
        'TEXT' => NumberFormat::FORMAT_TEXT,
        'DATE_DD-MM-YYYY' => 'dd-mm-yyyy',
        'NUMERIC_FORMATTED' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        'DATE_YYYY-MM-DD' => 'yyyy-mm-dd',
        'CURRENCY_LEI' => '#,##0_-"lei"',
    ];


    public function columnFormats(): array
    {
        return [];
    }


    public function addColumnFormats(array $formats): void
    {
        $this->cell_formats = array_merge($this->cell_formats, $formats);
    }
}
