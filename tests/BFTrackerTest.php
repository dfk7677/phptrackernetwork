<?php
require 'src/BFTracker.php';
require 'src/BFTrackerException.php';
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use dfk7677\phptrackernetwork\BFTracker;
use dfk7677\phptrackernetwork\BFTrackerException;
 
class BFTrackerTest extends TestCase
{
    public function testStatsByNicknameForInvalidAPIKey()
    {
        $this->expectException(BFTrackerException::class);
        $this->expectExceptionMessage('Bad Request');
        $this->expectExceptionCode(400);
        $apiKey = "incorrectapikey";        
        $mockClient = $this->_getMockClient($apiKey);
        $mockClient->request('GET', '/');
        
    }

    public function testStatsByIdForInvalidAPIKey()
    {
        $this->expectException(BFTrackerException::class);
        $this->expectExceptionMessage('Bad Request');
        $this->expectExceptionCode(400);
        $apiKey = "incorrectapikey";        
        $mockClient = $this->_getMockClient($apiKey);
        $mockClient->request('GET', '/');
    }

    public function testStatsByNicknameForInvalidNickname()
    {
        $this->expectException(BFTrackerException::class);
        $this->expectExceptionMessage('No account with that nickname found.');
        $this->expectExceptionCode(400);
        $apiKey = "correctapikey";        
        $mockClient = $this->_getMockClient($apiKey, null, "invalidnickname");
        $mockClient->request('GET', '/');
        
    }

    public function testStatsByIdForInvalidId()
    {
        $this->expectException(BFTrackerException::class);
        $this->expectExceptionMessage('No account with that platform ID found.');
        $this->expectExceptionCode(400);
        $apiKey = "correctapikey";        
        $mockClient = $this->_getMockClient($apiKey, 1);
        $mockClient->request('GET', '/');
        
    }

    public function testStatsByNicknameForValidNickname()
    {
        $apiKey = "correctapikey";        
        $mockClient = $this->_getMockClient($apiKey, null, "dfk_7677");
        $response = $mockClient->request('GET', '/');
        $this->assertEquals($response->getStatusCode(), 200);
    }

    public function testStatsByNicknameForValidId()
    {
        $apiKey = "correctapikey";        
        $mockClient = $this->_getMockClient($apiKey, 176484954);
        $response = $mockClient->request('GET', '/');
        $this->assertEquals($response->getStatusCode(), 200);
    }

    private function _getMockClient($apiKey, $id = null, $nickname = null)
    {
        $body = "Mock server response";
        if ($apiKey != "correctapikey") {
            $response = new BFTrackerException("Bad Request");
        } else {
            if (is_null($nickname)) {
                if ($id == 176484954) {
                    $response = new Response(200, [], $body);
                } else {
                    $response = new BFTrackerException("No account with that platform ID found.");
                }
            } else {
                if ($nickname == "dfk_7677") {
                    $response = new Response(200, [], $body);
                } else {
                    $response = new BFTrackerException("No account with that nickname found.");
                }
            }
            
        }
        
        
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
       
        return $client;
    }
 
}