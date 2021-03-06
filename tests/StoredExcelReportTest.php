<?php


namespace Lab36\ExcelReport\Tests;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPUnit\Framework\TestCase;

class StoredExcelReportTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();// TODO: Change the autogenerated stub
    }


    /** @test */
    public function file_title_should_be_at_column_A()
    {
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load('from-array.xlsx');

        $this->assertEquals('from array', $spreadsheet->getActiveSheet()->getCell('A1')->getValue(), 'spreadsheet title at A1 should be from array');
    }


    /** @test */
    public function no_of_column_should_be_3()
    {
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load('from-array.xlsx');
        $column_no = Coordinate::columnIndexFromString($spreadsheet->getActiveSheet()->getCellCollection()->getCurrentColumn());

        $this->assertEquals(3, $column_no, 'spreadsheet should have 3 columns');
    }

}
