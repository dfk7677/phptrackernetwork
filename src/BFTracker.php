<?php
namespace dfk7677\phptrackernetwork;

use dfk7677\phptrackernetwork\BFTrackerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7;


class BFTracker
{
    
    private $_baseUri;
    private $_client;
    private $_apiKey;
    
    public function __construct($apiKey)
    {
        $this->_baseUri = "https://battlefieldtracker.com/bf1/api/Stats/";
        $this->_client = new Client;
        $this->_apiKey = $apiKey;
        
    }

    public function __destruct()
    {
        //curl_close($this->ch);
    }

    public function GetBasicStatsByNickname($nickname, $platform = 3, $game = "tunguska")
    {
        try {
            /** @var Response $response */
            $response = $this->_client->request(
                'GET',
                $this->_baseUri."BasicStats?platform=".$platform."&game=".$game.
                "&displayName=".$nickname,
                ['headers' => ['TRN-Api-Key' => $this->_apiKey]]
            );
            /** @var Stream $body */
            $body = $response->getBody();
            $json = json_decode($body->getContents());
            if (!$json->success) {
                $this->throwException("No account with that nickname found.");
            }
            return $json;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                
                $this->throwException($response->getBody()->getContents());
            }
            $this->throwException("Unknown exception");
        }
       
    }

    public function GetBasicStatsById($id, $platform = 3, $game = "tunguska")
    {
        try {
            /** @var Response $response */
            $response = $this->_client->request(
                'GET',
                $this->_baseUri."BasicStats?platform=".$platform."&game=".$game.
                "&personaId=".$id,
                [
                    'headers' => ['TRN-Api-Key' => $this->_apiKey]
                ]
            );
            /** @var Stream $body */
            $body = $response->getBody();
            $json = json_decode($body->getContents());
            if (!$json->success) {
                $this->throwException("No account with that platform ID found.");
            }
            return $json;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $this->throwException($response->getBody()->getContents());
            }
            $this->throwException("Unknown exception");
        }
    }

    private function throwException($message, $code = 400)
    {
        throw new BFTrackerException($message, $code);
    }
}
