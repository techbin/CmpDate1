
[![Build Status](https://travis-ci.org/techbin/cmpdate.svg?branch=master)](https://travis-ci.org/techbin/cmpdate)

### CmpDate
A simple Restful API to calculate days, weekdays and complete weeks between two dates. The app is built using **[Slim](https://www.slimframework.com/)**.

### Usage
Clone this repository:

```
    git clone https://github.com/techbin/cmpdate.git
```

Change your directory to `cmpdate` directory:

```
    cd cmpdate
```

Install package dependencies:

```
    composer install
```

Boot-up the API service with PHP's Built-in web server:

```
    composer start
```

Test

```
    composer test
```

### API

Get days, weekdays or complete weeks for a range of dates by providing `startdate`, `enddate` and `convertresult`.

`startdate`     - first parameter is start date (required).
`enddate`       - second parameter is end date (required).

Syntax: 2020-04-04 07:20:10 (datetime) or 2020-04-04 00:00:00 Australia/Adelaide (datetime with timezone)

`convertresult` - third parameter (optional) can be used to convert the result into one of hours, minutes, seconds or years.

Syntax: h,m,s,y

* `http://localhost:8080/datediff/days` - get days between between dates.

Request Header Parameters

```

  'REQUEST_METHOD'  => 'POST',
  'CONTENT_TYPE'    => 'application/json;'

```

Request Body Parameters

```
{
"startdate":"2020-04-04 07:00:00 Australia/Adelaide",
"enddate":"2020-04-06 10:10:00 Australia/Adelaide",
"convertresult":"h"
}
```

Response

Json response - if Successful `Data` will show number of days or hours, minutes, seconds and years based on the third parameter.

Successful response
```
{
  "status": "success",
  "data": 52
}
```
Error response
```
{
  "status": "error",
  "message": "Both start and end dates are required fields"
}

```
* `http://localhost:8080/datediff/weekdays` - get weekdays between dates.
* `http://localhost:8080/datediff/completeweeks`  - get complete weeks between dates


### Code Overview

Entry Point:

The server will direct all requests to [index.php](public/index.php).
There, we boot the app by creating an instance of Slim\App and require all the settings and relevant files.

Finally, we run the app by calling `$app->run()`, which will process the request and send the response.

Directory Structure:

> Package includes three important files in cmpdate directory: `cmpdateconfig.php`configuration file, `api.php` routing file, `cmpdate.php` compare date logic file
> Package also includes `datatest.php` file in tests directory.

Copyright (c) 2020 Satish Kumar <satish.prg@gmail.com>
