<?php
/**
 * TrackerNetworkClient.php.
 *
 * PHP version 7.1
 *
 * @author  Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @link    https://github.com/dfk7677/phptrackernetwork
 */

namespace dfk7677\phptrackernetwork;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class TrackerNetworkClient.
 *
 * @author  Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @link    https://github.com/dfk7677/phptrackernetwork
 */
class TrackerNetworkClient extends Client
{
    protected $baseUri;
    protected $client;
    protected $apiKey;

    /**
     * Construction function
     * Initialization of variables.
     *
     * @param string $apiKey  Tracker Network API key
     * @param string $baseUri Base URI for API calls
     */
    public function __construct(
        $apiKey,
        $baseUri
    ) {
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
        parent::__construct();
    }
    /**
     * Function TRNrequest
     * Makes the request to the Tracker Network API and returns the response object.
     *
     * @param string $uri   Uri for request depending on function
     * @param array  $query Query variables
     */
    public function TRNrequest(
        $uri,
        $query
    ) {
        
        try {
            $response = parent::request(
                'GET',
                $this->baseUri.$uri,
                [
                    'headers' => ['TRN-Api-Key' => $this->apiKey],
                    'query'   => [
                        'platform'  => 3,
                        'game'      => 'tunguska',
                        'displayName' => 'dfk_7677'
                    ]
                ]
            );
            return json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Function handleException
     * Returns object response depending on response exception.
     *
     * @param ClientException $exception Guzzle thrown exception
     *
     * @return object
     */
    protected function handleException($exception)
    {
        if ($exception->hasResponse()) {
            $content = $exception->getResponse()->getBody()->getContents();
            $object = json_decode($content);
            if (json_last_error() != JSON_ERROR_NONE) {
                $object = json_decode(
                    '{
                        "successful": false,
                        "errorData": {
                            "errorMessage": "Incorrect API key.",
                            "errorCode": 1
                        }
                    }'
                );
            }

            return $object;
        } else {
            return json_decode(
                '{
                    "successful": false,
                    "errorData": {
                        "errorMessage": "Unknown exception.",
                        "errorCode": 3
                    }
                }'
            );
        }
    }
}