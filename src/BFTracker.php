<?php
/**
 * BFTracker.php.
 *
 * PHP version 7.1
 *
 * @author  Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @link    https://github.com/dfk7677/phptrackernetwork
 */

namespace dfk7677\phptrackernetwork;
require('src/TrackerNetworkClient.php');

use dfk7677\phptrackernetwork\TrackerNetworkClient;

/**
 * Class BFTracker.
 *
 * @author  Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @link    https://github.com/dfk7677/phptrackernetwork
 */
class BFTracker
{
    protected $baseUri;
    protected $client;
    protected $apiKey;

    /**
     * Construction function
     * Initialization of variables.
     *
     * @param string $apiKey  Tracker Network API key
     * @param string $baseUri Base URI for Battlefield stats API calls
     */
    public function __construct(
        $apiKey,
        $baseUri = "https://battlefieldtracker.com/bf1/api/"
    ) {
        $this->client = new TrackerNetworkClient($apiKey, $baseUri);
    }
}

/**
 * Class BFTrackerStats
 * Class to retrive stats from BFTracker.
 *
 * @author  Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @link    https://github.com/dfk7677/phptrackernetwork
 */
class BFTrackerStats extends BFTracker
{
    private $_path;

    /**
     * Construction function
     * Initialization of variables.
     *
     * @param string $apiKey  Tracker Network API key
     * @param string $baseUri Base URI for Battlefield stats API calls
     */
    public function __construct(
        $apiKey,
        $baseUri = 'https://battlefieldtracker.com/bf1/api/'
    ) {
        $this->_path = 'Stats/';
        parent::__construct($apiKey, $baseUri);
    }

    /**
     * Function getBasicStatsByNickname
     * Returns Basic Stats for player by his Origin username.
     *
     * @param string $nickname Origin username
     * @param int    $platform Platform ID
     * @param string $game     Game codename
     *
     * @return object
     */
    public function getBasicStatsByNickname(
        $nickname,
        $platform = 3,
        $game = 'tunguska'
    ) {
        $functionPath = 'BasicStats';
        $query = [
            'platform'    => $platform,
            'game'        => $game,
            'displayName' => $nickname
        ];
        return $this->client->TRNrequest($this->_path.$functionPath, $query);
    }

    /**
     * Function getBasicStatsById
     * Returns Basic Stats for player by his Origin ID.
     *
     * @param int    $id       Origin ID
     * @param int    $platform Platform ID
     * @param string $game     Game codename
     *
     * @return object
     */
    public function getBasicStatsById(
        $id,
        $platform = 3,
        $game = 'tunguska'
    ) {
        $functionPath = 'BasicStats';
        $query = [
            'platform'  => $platform,
            'game'      => $game,
            'personaId' => $id
        ];
        return $this->client->TRNrequest($this->_path.$functionPath, $query);
    }

    /**
     * Function getDetailedStatsByNickname
     * Returns Detailed Stats for player by his Origin username.
     *
     * @param string $nickname Origin username
     * @param int    $platform Platform ID
     * @param string $game     Game codename
     *
     * @return object
     */
    public function getDetailedStatsByNickname(
        $nickname,
        $platform = 3,
        $game = 'tunguska'
    ) {
        $functionPath = 'DetailedStats';
        $query = [
            'platform'    => $platform,
            'game'        => $game,
            'displayName' => $nickname
        ];
        return $this->client->TRNrequest($this->_path.$functionPath, $query);
    }

    /**
     * Function getDetailedStatsById
     * Returns Detailed Stats for player by his Origin ID.
     *
     * @param int    $id       Origin ID
     * @param int    $platform Platform ID
     * @param string $game     Game codename
     *
     * @return object
     */
    public function getDetailedStatsById(
        $id,
        $platform = 3,
        $game = 'tunguska'
    ) {
        $functionPath = 'DetailedStats';
        $query = [
            'platform'  => $platform,
            'game'      => $game,
            'personaId' => $id
        ];
        return $this->client->TRNrequest($this->_path.$functionPath, $query);
    }
}
