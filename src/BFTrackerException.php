<?php
namespace dfk7677\phptrackernetwork;
use Exception;
 
class BFTrackerException extends Exception
{
    public function __construct($message, $code = 400)
    {
        parent::__construct($message, $code);
    }
}