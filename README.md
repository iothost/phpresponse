##iothost/phpresponse

Simple PHP class to handle responses correctly.

####Installation
``composer require iothost/phpresponse``


####Example usage
```
$loader = require './vendor/autoload.php';
$response = new \Iothost\PhpResponse\Response();

// add header
$response->addHeader('Cache-Control: no-cache');

// set Content-Type, can be entered as a string
$response->addHeader($response::CT_TEXT);

// set HTTP status code, can be entered as a number (int)
$response->setStatus($response::STATUS_OK);

// set response body as a string
$response->setBody($string);
// OR
// set response body as JSON (from array)
$response->setBodyJson($array);


// send response
$response->send();
```