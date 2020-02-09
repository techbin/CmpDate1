<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Slim\Http\Environment;
use Slim\Http\Request;
/**
 * DateTest - Unit test class
 *
 * @package CmpDate
 * @author  Satish Kumar <satish.prg@gmail.com>
 */
class DateTest extends PHPUnit_TestCase
{
    protected $app;
    public function setUp()
    {
        $this->app = (new \CmpDate\Api())->get();
    }

    /**
     * Test bootstrap
     */
    public function testBootStrap()
    {
        $env = Environment::mock(
            [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/',
            ]
        );
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame((string)$response->getBody(), "Date Compare API");
    }

    /**
    * Test days between dates api
    */
    public function testDaysBetweenDates()
    {
        $env = Environment::mock(
            [
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI'    => '/datediff/days',
            'CONTENT_TYPE' => 'application/json;charset=utf8'
            ]
        );
        //test days between dates
        $data = array(
        "startdate" => "2020-04-04 00:00:00 Australia/Adelaide",
        "enddate" => "2020-04-06 00:00:00 Australia/Adelaide",
        "convertresult" => ""
        );

        $req = Request::createFromEnvironment($env)->withParsedBody($data);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode((string)$response->getBody());
        $this->assertSame($result->data, 2);

        //test hours between days
        $data = array(
        "startdate" => "2020-04-04 00:00:00 Australia/Adelaide",
        "enddate" => "2020-04-06 00:00:00 Australia/Adelaide",
        "convertresult" => "h"
        );
        $req = Request::createFromEnvironment($env)->withParsedBody($data);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode((string)$response->getBody());
        $this->assertSame($result->data, 49);//Test Daylight saving time
    }

    /**
    * Test weekdays api
    */
    public function testWeekDaysBetweenDates()
    {
        $env = Environment::mock(
            [
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI'    => '/datediff/weekdays',
            'CONTENT_TYPE' => 'application/json;charset=utf8'
            ]
        );

        $data = array(
        "startdate" => "2020-03-01 00:00:00 Australia/Adelaide",
        "enddate" => "2020-08-01 00:00:00 Australia/Adelaide",
        "convertresult" => ""
        );

        $req = Request::createFromEnvironment($env)->withParsedBody($data);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode((string)$response->getBody());
        $this->assertSame($result->data, 110);
    }
    /**
    * Test completed weeks api
    */
    public function testCompleteWeeksBetweenDates()
    {
        $env = Environment::mock(
            [
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI'    => '/datediff/completeweeks',
            'CONTENT_TYPE' => 'application/json;charset=utf8'
            ]
        );

        $data = array(
        "startdate" => "2020-03-01 00:00:00 Australia/Adelaide",
        "enddate" => "2020-08-01 00:00:00 Australia/Adelaide",
        "convertresult" => ""
        );

        $req = Request::createFromEnvironment($env)->withParsedBody($data);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode((string)$response->getBody());
        $this->assertSame($result->data, 21);
    }
}
