<?php
/**
 * BFTracker.php
 *  
 * PHP version 7.1
 * 
 * @category API_Wrapper
 * @package  Phptrackernetwork
 * @author   Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/dfk7677/phptrackernetwork
 */

namespace dfk7677\phptrackernetwork;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

/**
 * Class BFTracker
 *  
 * @category API_Wrapper
 * @package  BFTracker
 * @author   Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/dfk7677/phptrackernetwork
 */

class BFTracker
{
    protected $baseUri;
    protected $client;
    protected $apiKey;
    
    /** 
     * Construction function
     * Initialization of variables
     * 
     * @param string $apiKey  Tracker Network API key
     * @param string $baseUri Base URI for Battlefield stats API calls
     */
    public function __construct(
        $apiKey, 
        $baseUri = "https://battlefieldtracker.com/bf1/api/"
    ) {
        $this->baseUri = $baseUri;
        $this->client = new Client;
        $this->apiKey = $apiKey;
    }

    

    /** 
     * Function handleException
     * Returns object response depending on response exception
     * 
     * @param ClientException $exception Guzzle thrown exception
     * 
     * @return object 
     */
    protected function handleException($exception)
    {
        if ($exceptione->hasResponse()) {                
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

/**
 * Class BFTrackerStats
 *  
 * Class to retrive stats from BFTracker
 * 
 * @category API_Wrapper
 * @package  BFTracker
 * @author   Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/dfk7677/phptrackernetwork
 */

class BFTrackerStats extends BFTracker
{
    private $_path;
    /** 
     * Construction function
     * Initialization of variables
     * 
     * @param string $apiKey  Tracker Network API key
     * @param string $baseUri Base URI for Battlefield stats API calls
     */
    public function __construct(
        $apiKey, 
        $baseUri = "https://battlefieldtracker.com/bf1/api/"
    ) {
        $this->_path = "Stats/";
        parent::__construct($apiKey, $baseUri);
    }
    
    /** 
     * Function getBasicStatsByNickname 
     * Returns Basic Stats for player by his Origin username
     * 
     * @param string  $nickname Origin username
     * @param integer $platform Platform ID
     * @param string  $game     Game codename
     * 
     * @return object
     */
    public function getBasicStatsByNickname(
        $nickname,
        $platform = 3,
        $game = "tunguska"
    ) {
        $functionPath = "BasicStats";
        try {
            $response = $this->client->request(
                'GET',
                $this->baseUri.$this->_path.$functionPath,
                [
                    'headers' => ['TRN-Api-Key' => $this->apiKey],
                    'query' => [
                        'platform' => $platform,
                        'game' => $game,
                        'displayName' => $nickname
                        ]
                ]
            ); 
            return json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            return $this->handleException($e);
        }       
    }

    /** 
     * Function getBasicStatsById
     * Returns Basic Stats for player by his Origin ID
     * 
     * @param integer $id       Origin ID
     * @param integer $platform Platform ID
     * @param string  $game     Game codename
     * 
     * @return object
     */
    public function getBasicStatsById(
        $id,
        $platform = 3,
        $game = "tunguska"
    ) {
        $functionPath = "BasicStats";
        try {            
            $response = $this->client->request(
                'GET',
                $this->baseUri.$this->_path.$functionPath,
                [
                    'headers' => ['TRN-Api-Key' => $this->apiKey],
                    'query' => ['platform' => $platform,
                    'game' => $game,
                    'personaId' => $id
                    ]
                ]
            );            
            return json_decode($response->getBody()->getContents());            
        } catch (ClientException $e) {
            return $this->handleException($e);           
        }
    }

    /** 
     * Function getDetailedStatsByNickname function
     * Returns Detailed Stats for player by his Origin username
     * 
     * @param string  $nickname Origin username
     * @param integer $platform Platform ID
     * @param string  $game     Game codename
     * 
     * @return object
     */
    public function getDetailedStatsByNickname(
        $nickname,
        $platform = 3,
        $game = "tunguska"
    ) {
        $functionPath = "DetailedStats";
        try {
            $response = $this->client->request(
                'GET',
                $this->baseUri.$this->_path.$functionPath,
                [
                    'headers' => ['TRN-Api-Key' => $this->apiKey],
                    'query' => [
                        'platform' => $platform,
                        'game' => $game,
                        'displayName' => $nickname
                        ]
                ]
            ); 
            return json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            return $this->handleException($e);
        }       
    }

    /** 
     * Function getDetailedStatsById function
     * Returns Detailed Stats for player by his Origin ID
     * 
     * @param integer $id       Origin ID
     * @param integer $platform Platform ID
     * @param string  $game     Game codename
     * 
     * @return object
     */
    public function getDetailedStatsById(
        $id,
        $platform = 3,
        $game = "tunguska"
    ) {
        $functionPath = "DetailedStats";
        try {            
            $response = $this->client->request(
                'GET',
                $this->baseUri.$this->_path.$functionPath,
                [
                    'headers' => ['TRN-Api-Key' => $this->apiKey],
                    'query' => ['platform' => $platform,
                    'game' => $game,
                    'personaId' => $id
                    ]
                ]
            );            
            return json_decode($response->getBody()->getContents());            
        } catch (ClientException $e) {
            return $this->handleException($e);           
        }
    }
}