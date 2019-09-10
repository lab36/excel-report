<?php

namespace Lab36\ExcelReport;

use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

abstract class ExcelReport
{
    use ColumnFormats, ColumnAlignment;


    /**
     * @var int
     */
    private $title_row_no = 1;
    /**
     * @var int
     */
    private $header_row_no = 4;
    /**
     * @var int
     */
    private $filter_row_no = 5;
    /**
     * @var string
     */
    private $title = '';
    /**
     * @var array
     */
    private $column_mapping = [];
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var array
     */
    private $filters = [];
    /**
     * @var string
     */
    private $file_name = '';
    /**
     * @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    private $activeSheet;
    /**
     * @var int
     */
    private $no_of_columns = 1;
    /**
     * @var Spreadsheet
     */
    private $spreadsheet;
    /**
     * @var array
     */
    private $column_formats = [];
    /**
     * @var array
     */
    private $column_alignment = [];
    /**
     * @var array
     */
    private $column_width = [];
    /**
     * @var ExcelThemeInterface
     */
    private $theme = null;


    public static function fromArray($title, array $data)
    {
        $self = new static();

        return $self->init($title, $data);
    }


    public static function fromCollection($title, \Illuminate\Support\Collection $data)
    {
        $self = new static();

        return $self->init($title, $data);
    }


    private function init($title, $data)
    {
        $this->title = $title;
        $this->data = $data;
        $this->column_mapping = $this->columnMappings();
        $this->column_formats = $this->columnFormats();
        $this->column_alignment = $this->columnAlignment();
        $this->column_width = $this->columnWidth();
        $this->no_of_columns = count($this->column_mapping);

        $this->spreadsheet = new Spreadsheet();
        $this->activeSheet = $this->spreadsheet->getActiveSheet();
        $default_theme = config('excel-report.default_theme', ExcelReportDefaultTheme::class);
        $this->theme = new $default_theme;

        return $this;
    }


    /**
     * Set column to title mapping
     * only columns that appear in this array are written to excel
     * on the right side we have the title from header
     * [ 'column_1' => 'title_1',
     *   'column_2' => 'title_2']
     *
     * ['first_name'=>'First Name',
     *   'last_name'=>'Last Name']
     *
     * @return array
     */
    abstract function columnMappings(): array;


    public function columnWidth(): array
    {
        return [];
    }


    public function setTheme(ExcelThemeInterface $theme)
    {
        $this->theme = $theme;

        return $this;
    }


    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }


    public function download($file_name = '')
    {
        $this->create();

        $this->file_name = $file_name != '' ? Str::slug($file_name).'.xlsx' : Str::slug($this->title).'.xlsx';
        $file_path = rtrim(sys_get_temp_dir(), '/').'/'.$this->file_name;
        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save($file_path);

        return response()->download(
            $file_path,
            $this->file_name,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="'.$this->file_name.'"',
                'Cache-Control' => 'no-store',
                'Last-Modified' => ''.gmdate('D, d M Y H:i:s').' GMT',
                'Pragma' => 'public',
            ]
        )->deleteFileAfterSend(true);
    }


    public function store($file_name = '', $path = ''): string
    {
        $this->create();

        $this->file_name = $file_name !== '' ? Str::slug($file_name) : Str::slug($this->title);
        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save(rtrim($path, '/').'/'.$this->file_name.'.xlsx');

        return $this->file_name.'.xlsx';
    }


    private function printTitle(): ExcelReport
    {
        $this->activeSheet->setTitle(substr($this->title, 0, 30));
        $this->activeSheet->setCellValue("A{$this->title_row_no}", $this->title);
        $this->activeSheet->mergeCells($this->getCurrentRowRange($this->title_row_no));

        return $this;
    }


    private function printFilters(): ExcelReport
    {
        if ( ! count($this->filters)) {

            return $this;
        }

        $filters_with_columns = [];
        $i = 1;
        foreach ($this->column_mapping as $key => $value) {
            if (isset($this->filters[$key])) {
                $this->activeSheet->setCellValue(Coordinate::stringFromColumnIndex($i).$this->filter_row_no, $this->filters[$key]);
                $filters_with_columns[$key] = '';
            }
            $i++;
        }

        $filters_without_columns = array_diff_key($this->filters, $filters_with_columns);
        $filter_without_column = '';
        foreach ($filters_without_columns as $key => $filter) {
            $filter_without_column .= $key.': '.$filter.', ';
        }

        if (strlen($filter_without_column)) {
            $this->activeSheet->setCellValue(Coordinate::stringFromColumnIndex($this->no_of_columns + 1).$this->filter_row_no, $filter_without_column);
        }


        return $this;
    }


    /**
     * @return string
     */
    private function getLastColumn(): string
    {
        return Coordinate::stringFromColumnIndex($this->no_of_columns);
    }


    private function getCurrentRowRange($row): string
    {
        return "A{$row}:{$this->getLastColumn()}{$row}";
    }


    private function printHeader(): ExcelReport
    {
        $this->activeSheet->fromArray(array_values($this->column_mapping), null, "A".$this->header_row_no);

        return $this;
    }


    private function printData(): void
    {
        $current_row = max($this->title_row_no, $this->filter_row_no, $this->header_row_no) + 1;
        $this->columnFormat();

        foreach ($this->data as $row_data) {
            if (is_object($row_data)) {
                $row_data = (array)$row_data;
            }
            $i = 1;
            $this->theme->applyRowStyle($this->activeSheet, $current_row, $row_data);
            foreach ($this->column_mapping as $key => $value) {
                $this->theme->applyCellStyle($this->activeSheet, $current_row, $i, $value);
                $this->activeSheet->setCellValue(Coordinate::stringFromColumnIndex($i).$current_row, $row_data[$key]);
                if ($this->shouldFormatDate($key, $row_data[$key])) {
                    $this->activeSheet->setCellValue(Coordinate::stringFromColumnIndex($i).$current_row, Date::PHPToExcel(Carbon::parse($row_data[$key])->toDateString()));
                }
                $this->overrideCell($this->activeSheet, $current_row, $i, $row_data[$key], $row_data, $key);

                $i++;
            }

            $current_row++;
        }
    }


    public function overrideCell(Worksheet $active_sheet, int $current_row_no, int $column_no, $value, array $row_data, string $column_name)
    {
        return;
    }


    private function shouldFormatDate($key, $value)
    {
        return $this->isDefinedCustomStyle($key)
               && strpos($this->column_formats[$key], 'DATE') !== false
               && ! empty($value);
    }


    /**
     * @param int|string $key
     *
     * @return bool
     */
    private function isDefinedCustomStyle($key): bool
    {
        return isset($this->column_formats[$key])
               && in_array($this->column_formats[$key], array_keys($this->cell_formats));
    }


    /**
     * @param int|string $key
     *
     * @return bool
     */
    private function isDefinedColumnAlignment($key): bool
    {
        return isset($this->column_alignment[$key])
               && in_array($this->column_alignment[$key], array_keys($this->cell_alignment));
    }


    /**
     * @param int|string $key
     *
     * @return bool
     */
    private function isDefinedColumnWidth($key): bool
    {
        return isset($this->column_width[$key]);
    }


    /**
     * @return ExcelReport
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function columnFormat(): ExcelReport
    {
        $i = 1;
        foreach ($this->column_mapping as $key => $value) {
            $column_range = Coordinate::stringFromColumnIndex($i).($this->header_row_no + 1).':'.Coordinate::stringFromColumnIndex($i).(count($this->data) + $this->header_row_no + 1);
            if ($this->isDefinedCustomStyle($key)) {
                $this->activeSheet->getStyle($column_range)
                                  ->getNumberFormat()
                                  ->setFormatCode($this->cell_formats[$this->column_formats[$key]]);
            }
            if ($this->isDefinedColumnAlignment($key)) {
                $this->activeSheet->getStyle($column_range)
                                  ->getAlignment()
                                  ->setHorizontal($this->cell_alignment[$this->column_alignment[$key]]);
            }
            if ($this->isDefinedColumnWidth($key)) {
                $this->activeSheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))
                                  ->setWidth($this->column_width[$key]);
                $this->activeSheet->getStyle($column_range)
                                  ->getAlignment()
                                  ->setWrapText(true);
            } else {
                $this->activeSheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
            }
            $i++;
        }

        return $this;
    }


    /**
     * @param int $header_row_no
     *
     * @return ExcelReport
     */
    public function setHeaderRowNo(int $header_row_no): ExcelReport
    {
        $this->header_row_no = $header_row_no;

        return $this;
    }


    /**
     * @param int $filter_row_no
     *
     * @return ExcelReport
     */
    public function setFilterRowNo(int $filter_row_no): ExcelReport
    {
        $this->filter_row_no = $filter_row_no;

        return $this;
    }


    /**
     * @param int $title_row_no
     *
     * @return ExcelReport
     */
    public function setTitleRowNo(int $title_row_no): ExcelReport
    {
        $this->title_row_no = $title_row_no;

        return $this;
    }


    private function setFileProperties()
    {
        $this->spreadsheet->getProperties()
                          ->setCreator(config('excel-report.file_properties.creator'))
                          ->setLastModifiedBy(config('excel-report.file_properties.last_modified_by'))
                          ->setTitle(config('excel-report.file_properties.title'))
                          ->setSubject(config('excel-report.file_properties.subject'))
                          ->setDescription(config('excel-report.file_properties.description'))
                          ->setKeywords(config('excel-report.file_properties.keywords'))
                          ->setCategory(config('excel-report.file_properties.category'));
    }


    private function create(): void
    {
        $this->setFileProperties();
        $this->printTitle();
        $this->printHeader();
        $this->printFilters();
        $this->printData();
        $this->theme->apply(
            $this->activeSheet,
            $this->title_row_no,
            $this->filter_row_no,
            $this->header_row_no,
            count($this->data) + max($this->filter_row_no, $this->header_row_no),
            $this->no_of_columns
        );
    }
}
