<?php
declare(strict_types=1);
namespace CmpDate;
/**
* CmpDate- Main class implements CmpDateInterface functions with logic
 *
 * @package CmpDate
 * @author  Satish Kumar <satish.prg@gmail.com>
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
/**
 * CmpDateInterface - list the functions to be implemented
 */
interface CmpDateInterface
{
    public function calculateDays(): int;
    public function calculateWeekdays(): int;
    public function calculateCompleteWeeks(): int;
}
/**
 * CmpDate- Main class implements CmpDateInterface functions that define logic
 */
class CmpDate implements CmpDateInterface
{
    private $_datefrom;
    private $_dateto;
    private $_restype;
    private $_configuration;

    public function __construct(CmpDateConfig $_configuration)
    {
        $this->_datefrom = new \DateTime($_configuration->getStartDate());
        $this->_dateto = new \DateTime($_configuration->getEndDate());
        $this->_restype = $_configuration->getConvertResult();
    }
    /**
     * Function to calculate days between two dates .
     *
     * @param void
     *
     * @return integer days(default), years, hours, mins, secs  between 2 dates
     */
    public function calculateDays(): int
    {
        $result = 0;
        $start = intval($this->_datefrom->getTimestamp());
        $end = intval($this->_dateto->getTimestamp());
        $diffinsecs = 0;
        if ($end > $start) {
            $diffinsecs = $end-$start;
        } else {
            $diffinsecs = $start-$end;
        }
        if (!empty($this->_restype)) {
            return intval($this::convertResult($diffinsecs));
        } else {
            return intval($diffinsecs/CmpDateConfig::SECSINDAY);
        }
    }

    /**
     * Function to calculate weekdays between two dates.
     *
     * @param void
     *
     * @return integer days(default), years, hours, mins, secs  between 2 dates
     */
    public function calculateWeekdays(): int
    {
        $result = 0;
        $interval = \DateInterval::createFromDateString('1 day');
        $period   = new \DatePeriod($this->_datefrom, $interval, $this->_dateto);
        $weekdays = 0;
        foreach ($period as $date) {
            if ($date->format("N") < 6) {
                $weekdays++;
            }
        }
        if (!empty($this->_restype)) {
            return $this::convertResult($weekdays * CmpDateConfig::SECSINHOUR);
        }
        return intval($weekdays);
    }

    /**
     * Function to calculate complete weeks between two dates .
     *
     * @param void
     *
     * @return integer weeks(default), years, hours, mins, secs  between 2 dates
     */
    public function calculateCompleteWeeks(): int
    {
        $result = 0;
        $start = intval($this->_datefrom->getTimestamp());
        $end = intval($this->_dateto->getTimestamp());
        $diffinsecs = 0;
        if ($end > $start) {
            $diffinsecs = $end-$start;
        } else {
            $diffinsecs = $start-$end;
        }
        if (!empty($this->_restype)) {
            return intval($this::convertResult($diffinsecs));
        } else {
            return intval($diffinsecs/(CmpDateConfig::WEEKDAYS * CmpDateConfig::SECSINDAY));
        }
    }
    /**
     * Function to convert seconds to value based on the third parameter
     *
     * @param integer seconds
     *
     * @return integer days(default), years, hours, mins, secs
     */
    protected function convertResult(int $diff): float
    {
        switch($this->_restype)
        {
        case "s":
            return $diff;
          break;
        case "m":
            return  $diff/CmpDateConfig::SECSINMIN;
          break;
        case "h":
            return $diff/CmpDateConfig::SECSINHOUR;
          break;
        case "y":
            return $diff/(CmpDateConfig::SECSINDAY * CmpDateConfig::DAYSINYEAR);
          break;
        default:
            return $diff/CmpDateConfig::SECSINDAY;
            break;
        }
    }
}
