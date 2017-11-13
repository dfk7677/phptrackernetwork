<?php
/**
 * BFTracker.php
 *  
 * @category API_Wrapper
 * @package  BFTracker
 * @author   Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT
 */

namespace dfk7677\phptrackernetwork;

use dfk7677\phptrackernetwork\BFTrackerException;
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
 */

class BFTracker
{
    private $_baseUri;
    private $_client;
    private $_apiKey;
    
    /** 
     * Construction function
     * Initialization of variables
     * 
     * @param string $apiKey  Tracker Network API key
     * @param string $baseUri Base URI for Battlefield stats API calls
     */
    public function __construct($apiKey, $baseUri = "https://battlefieldtracker.com/bf1/api/Stats/")
    {
        $this->_baseUri = $baseUri;
        $this->_client = new Client;
        $this->_apiKey = $apiKey;
        
    }

    /** 
     * GetBasicStatsByNickname function
     * Returns Basic Stats for player by his Origin username
     * 
     * @param string  $nickname Origin username
     * @param integer $platform Platform ID
     * @param string  $game     Game codename
     * 
     * @return object
     */
    public function getBasicStatsByNickname($nickname, $platform = 3, $game = "tunguska")
    {
        try {
            $response = $this->_client->request(
                'GET',
                $this->_baseUri.$path,
                [
                    'headers' => ['TRN-Api-Key' => $this->_apiKey],
                    'query' => ['platform' => $platform, 'game' => $game, 'displayName' => $nickname]
                ]
            ); 
            return json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            $object = json_decode($content);
            if (json_last_error() != JSON_ERROR_NONE) {
                $object = json_decode('{"successful": false, "bad_request": true}');
            }
            return $object;
        }
       
    }

    /** 
     * GetBasicStatsById function
     * Returns Basic Stats for player by his Origin ID
     * 
     * @param integer $id       Origin ID
     * @param integer $platform Platform ID
     * @param string  $game     Game codename
     * 
     * @return object
     */
    public function getBasicStatsById($id, $platform = 3, $game = "tunguska")
    {
        $path = "BasicStats";
        try {            
            $response = $this->_client->request(
                'GET',
                $this->_baseUri.$path,
                [
                    'headers' => ['TRN-Api-Key' => $this->_apiKey],
                    'query' => ['platform' => $platform, 'game' => $game, 'personaId' => $id]
                ]
            );            
            return json_decode($response->getBody()->getContents());            
        } catch (ClientException $e) {
            if ($e->hasResponse()) {                
                $content = $e->getResponse()->getBody()->getContents();
                $object = json_decode($content);
                if (json_last_error() != JSON_ERROR_NONE) {
                    $object = json_decode('{"successful": false, "bad_request": true}');
                }
                return $object;
            }
           
        }
    }

}
