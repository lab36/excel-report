<?php

namespace Lab36\ExcelReport;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ExcelReport\ExcelReport\Skeleton\SkeletonClass
 */
class ExcelReportFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'excel-report';
    }
}
