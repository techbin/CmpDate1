<?php
declare(strict_types=1);
namespace CmpDate;
/**
 * CmpDateConfig Class - Compare date configuration
 * Declare logic constants and initialise start, end date and response type.
 *
 * @package CmpDate
 * @author  Satish Kumar <satish.prg@gmail.com>
 */
class CmpDateConfig
{

    public const SECSINDAY = 86400;//24*60*60
    public const SECSINHOUR = 3600;//60*60
    public const SECSINMIN = 60;
    public const DAYSINYEAR = 365;
    public const WEEKDAYS= 7;
    public const INVALID_FIELD_MSG = 'Both Start and End dates are requried';
    public const INVALID_FIELD_ERRORCODE = 400;

    private $_startdate;
    private $_enddate;
    private $_restype;

    public function setStartDate(string $_startdate): void
    {
        $this->startdate = $_startdate;
    }
    public function getStartDate(): string
    {
        return $this->startdate;
    }
    public function setEndDate(string $_enddate): void
    {
        $this->enddate = $_enddate;
    }
    public function getEndDate(): string
    {
        return $this->enddate;
    }
    public function setConvertResult(string $_restype): void
    {
        $this->restype = $_restype;
    }
    public function getConvertResult(): string
    {
        return $this->restype;
    }
}
