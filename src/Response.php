<?php

namespace Iothost\PhpResponse;


class Response
{
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_ACCEPTED = 202;

    const STATUS_MOVED_PERM = 301;
    const STATUS_TEMPORARY_REDIRECT = 307;
    const STATUS_PERMANENT_REDIRECT = 308;


    const STATUS_NOT_FOUND = 404;

    const STATUS_NOT_IMPLEMENTED = 501;
    const STATUS_BAD_GATEWAY = 502;
    const STATUS_UNAVAILABLE = 503;



    const CT_JSON = "Content-Type: application/json";
    const CT_XML = "Content-Type: application/xml";
    const CT_CSV = "Content-Type: test/csv";
    const CT_TEXT = "Content-Type: test/plain";




    protected $headers;
    protected $status;
    protected $body;


    function __construct()
    {
        $this->headers = array();

    }


    /**
     * Set HTTP status code to be sent with response
     * @param $status HTTP status code to be sent, custom code or chosen from Response::STATUS_*
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * Add HTTP header to response
     * @param $header string Header as a string, for example: 'Cache-Control: no-cache'
     * @return $this
     */
    public function addHeader($header)
    {
        array_push($this->headers, $header);

        return $this;
    }


    /**
     * @param $body string Set response body to entered string
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }


    /**
     * @param $array array Set response body to valid json from array
     * @return $this
     */
    public function setBodyJson($array)
    {
        if (!is_array($array)) {
            throw new \UnexpectedValueException("\$array must be an array, " . gettype($array) . " can not be converted to JSON.");
        }
        $this->body = json_encode($array);
        $this->addHeader($this::CT_JSON);

        return $this;
    }


    /**
     * @param $array array Set body to valid XML from array
     * @return $this
     */
    public function setBodyXml($array)
    {
        if (!is_array($array)) {
            throw new \UnexpectedValueException("\$array must be an array.");
        }

        $xml = new \SimpleXMLElement('<data/>');
        array_walk_recursive($array, array($xml, 'addChild'));

        $this->body = $xml->asXML();
        $this->addHeader($this::CT_XML);

        return $this;
    }


    public function send()
    {
        // send headers
        for ($x = 0; $x < count($this->headers); $x++) {
            header($this->headers[$x]);
        }

        //send status code
        http_response_code($this->status);

        //send body
        echo $this->body;
    }




    public function debug()
    {
        echo "headers:" . PHP_EOL;
        for ($x = 0; $x < count($this->headers); $x++) {
            echo $this->headers[$x];
        }
    }

}