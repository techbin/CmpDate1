<?php
declare(strict_types=1);
namespace CmpDate;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
/**
 * API class with routes
 *
 * @package CmpDate
 * @author  Satish Kumar <satish.prg@gmail.com>
 */
class Api
{
    /**
     * Stores an instance of the Slim application.
     *
     * @var \Slim\App
     */
    private $_app;
    private $_cmpdate;
    public $configuration;
    public function __construct()
    {
        $_app = new \Slim\App;

        $_app->get(
            '/', function (Request $request, Response $response) {
                $response->getBody()->write("Date Compare API");
                return $response;
            }
        );
        //Route to get number of days between datetime
        $_app->post(
            '/datediff/days', function (Request $request, Response $response, $args) {

                $postedVar = $request->getParsedBody();
                if(empty($postedVar['startdate']) or empty($postedVar['enddate']))
                {
                  return $response->withJson(['status' => 'error', 'message' => CmpDateConfig::INVALID_FIELD_MSG], CmpDateConfig::INVALID_FIELD_ERRORCODE);
                }
                //compare date configuration
                $configuration = new CmpDateConfig();
                $configuration->setStartDate($postedVar['startdate']);
                $configuration->setEndDate($postedVar['enddate']);
                $configuration->setConvertResult($postedVar['convertresult']);
                //compare date logic
                $logic = new CmpDate($configuration);
                $result = $logic->calculateDays();
                return $response->withJson(['status' => 'success', 'data' => $result]);
            }
        );
        //Route to get number of weekdays
        $_app->post(
            '/datediff/weekdays', function (Request $request, Response $response, $args) {

                $postedVar = $request->getParsedBody();
                if(empty($postedVar['startdate']) or empty($postedVar['enddate']))
                {
                  return $response->withJson(['status' => 'error', 'message' => CmpDateConfig::INVALID_FIELD_MSG], CmpDateConfig::INVALID_FIELD_ERRORCODE);
                }
                $configuration = new CmpDateConfig();
                $configuration->setStartDate($postedVar['startdate']);
                $configuration->setEndDate($postedVar['enddate']);
                $configuration->setConvertResult($postedVar['convertresult']);

                $logic = new CmpDate($configuration);
                $result = $logic->calculateWeekdays();

                return $response->withJson(['status' => 'success', 'data' => $result]);
            }
        );
        //Route to get number of complete weeks
        $_app->post(
            '/datediff/completeweeks', function (Request $request, Response $response, $args) {

                $postedVar = $request->getParsedBody();
                if(empty($postedVar['startdate']) or empty($postedVar['enddate']))
                {
                  return $response->withJson(['status' => 'error', 'message' => CmpDateConfig::INVALID_FIELD_MSG], CmpDateConfig::INVALID_FIELD_ERRORCODE);
                }
                $configuration = new CmpDateConfig();
                $configuration->setStartDate($postedVar['startdate']);
                $configuration->setEndDate($postedVar['enddate']);
                $configuration->setConvertResult($postedVar['convertresult']);

                $logic = new CmpDate($configuration);
                $result = $logic->calculateCompleteWeeks();

                return $response->withJson(['status' => 'success', 'data' => $result]);
            }
        );
        $this->_app = $_app;
    }
    /**
     * Get an instance of the application.
     *
     * @return \Slim\App
     */
    public function get()
    {
        return $this->_app;
    }
}
