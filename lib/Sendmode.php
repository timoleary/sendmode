<?php

/*
    Sendmode
    Simple php library to help leverage the sendmode API.

*/

class Sendmode
{

    private $smusername;
    private $smpassword;
    private $senderid;
    public $endpoint;
    public $format;

    /**
     * Setup Username & Password
     * @param string $smusername Sendmode Username
     * @param string $smpassword Sendmode Password
     * @param string $senderid SMS Sender ID
     * @param string|null $format Format of data returned (json, array or default SimpleXMLElement Object)
     */

    function __construct($smusername, $smpassword, $senderid, $format = NULL)
    {
        $this->smusername = $smusername;
        $this->smpassword = $smpassword;
        $this->senderid = $senderid;
        $this->format = $format;
    }


    /**
     * Get account balance
     * @return object|array|json Returns SimpleXMLElement Object by default.
     */

    function getbalance()
    {
        $this->endpoint = 'https://api.sendmode.com/smspost.aspx';
        $data = array();

        $data['username'] = $this->smusername;
        $data['password'] = $this->smpassword;
        $data['Type'] = 'credits';

        $query = http_build_query($data);
        $response = $this->httpreq($query);
        return $response;
    }


    /**
     * Send SMS
     * @param string $number SMS recipient phone number
     * @param string $message Content of SMS
     * @param string|null $customerid Custom field that can be returned.
     * @param string|null $date Date to send message in dd/mm/yyyy format
     * @param string|null $time Time to send message in HH:mm format (24hrs)
     * @return object|json|array Returns SimpleXMLElement Object by default.
     */

    function send($number, $message, $customerid = NULL, $date = NULL, $time = NULL)
    {
        $this->endpoint = 'https://api.sendmode.com/smspost.aspx';

        $data = array();
        $data['Type'] = 'sendparam';
        $data['username'] = $this->smusername;
        $data['password'] = $this->smpassword;
        $data['senderid'] = $this->senderid;
        $data['Numto'] = $number;
        $data['data1'] = $message;

        if (isset($customerid)) {
            $data['customerid'] = $customerid;
        }

        if (isset($date)) {
            $data['date'] = $date;
        }

        if (isset($time)) {
            $data['time'] = $time;
        }

        $query = http_build_query($data);

        $response = $this->httpreq($query);
        return $response;
    }


    /**
     * Send Batch SMS
     * @param array $numbers array of SMS recipient phone numbers
     * @param string $message Content of SMS
     * @param string|null $date Date to send message in dd/mm/yyyy format
     * @param string|null $time Time to send message in HH:mm format (24hrs)
     * @return object|json|array Returns SimpleXMLElement Object by default.
     */

    function sendbatch($numbers, $message, $date = NULL, $time = NULL)
    {
        $batch = implode(';', $numbers);
        $response = $this->send($batch, $message, NULL, $date, $time);
        return $response;
    }


    /**
     * Get delivery report
     * @param string $customerid Customer ID used in the original SMS sendparam request.
     * @return object|json|array Returns SimpleXMLElement Object by default.
     */

    function getdeliveryreport($customerid)
    {
        $this->endpoint = 'https://api.sendmode.com/smsGetDeliveryReport.aspx';
        $data = array();

        $data['username'] = $this->smusername;
        $data['password'] = $this->smpassword;
        $data['customerid'] = $customerid;

        $query = http_build_query($data);
        $response = $this->httpreq($query);
        return $response;
    }


    /**
     * HTTP Request Method, leverages CURL with fallback to file_get_contents.
     * @param string $request http query to send to server
     * @return object|json|array Returns SimpleXMLElement Object by default (can be json or array see constructor).
     */

    function httpreq($request)
    {

        $response = function_exists('curl_version') ? $this->_curl($request) : $this->_file_get_contents($request);

        switch ($this->format) {

            case 'json':
                return json_encode(simplexml_load_string($response));
                break;

            case 'array':
                return json_decode(json_encode(simplexml_load_string($response)), TRUE);
                break;

            default:
                return simplexml_load_string($response);
                break;

        }

    }


    /**
     * CURL Request Method
     * @param string $args URL-encoded query string for API POST
     * @return string XML response returned as string.
     */

    function _curl($args)
    {

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->endpoint,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $args
        ));

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }


    /**
     * file_get_contents Request Method
     * @param string $args URL-encoded query string for API POST
     * @return string XML response returned as string.
     */

    function _file_get_contents($args)
    {

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $args
            )
        );

        $context = stream_context_create($opts);
        $output = file_get_contents($this->endpoint, false, $context);
        return $output;
    }


}
