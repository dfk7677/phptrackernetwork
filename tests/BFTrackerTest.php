<?php
/**
 * 
 */


require 'src/BFTracker.php';
require 'src/BFTrackerException.php';
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use dfk7677\phptrackernetwork\BFTracker;
use dfk7677\phptrackernetwork\BFTrackerException;
 
class BFTrackerTest extends TestCase
{
    protected $bftracker;

    protected function setUp()
    {
        $this->bftracker = new BFTracker("apikey");
    }

    public function testForInvalidAPIKey()
    {
        $this->expectException(BFTrackerException::class);
        $this->expectExceptionMessage('Bad Request');
        $this->expectExceptionCode(400);
        try {            
            $mock = new MockHandler([new RequestException("Bad Request", new Request('GET', 'test'))]);
            $handler = HandlerStack::create($mock);
            $client = new Client(['handler' => $handler]);
            $response = $client->request('GET', '/');
            $body = $response->getBody();
            $json = json_decode($body->getContents());
            if (!$json->success) {
                $bftracker->_throwException("No account with that platform ID found.");
            }
            return $json;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $bftracker->_throwException($response->getBody()->getContents());
            }
            $bftracker->_throwException("Unknown exception");
        }
        
        
    }

    /*
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
*/
    
 
}