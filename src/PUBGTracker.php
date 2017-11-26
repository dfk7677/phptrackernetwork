<?php
/**
 * PUBGTracker.php.
 *
 * PHP version 7.1
 *
 * @author  Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @link    https://github.com/dfk7677/phptrackernetwork
 */

namespace dfk7677\phptrackernetwork;


use dfk7677\phptrackernetwork\TrackerNetworkClient;

/**
 * Class PUBGTracker.
 *
 * @author  Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @link    https://github.com/dfk7677/phptrackernetwork
 */
class PUBGTracker
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
        $baseUri = "https://api.pubgtracker.com/v2/"
    ) {
        $this->client = new TrackerNetworkClient($apiKey, $baseUri);
    }
}

/**
 * Class PUBGTrackerStats
 * Class to retrieve stats from PUBGTracker.
 *
 * @author  Dionysis Kapatsoris <dfk_7677@yahoo.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @link    https://github.com/dfk7677/phptrackernetwork
 */
class PUBGTrackerStats extends PUBGTracker
{
    /**
     * Construction function
     * Initialization of variables.
     *
     * @param string $apiKey  Tracker Network API key
     * @param string $baseUri Base URI for Battlefield stats API calls
     */
    public function __construct(
        $apiKey,
        $baseUri = 'https://api.pubgtracker.com/v2/profile/'
    ) {
        parent::__construct($apiKey, $baseUri);
    }
    /**
     * Function getStatsByNickname
     * Returns Stats for player by player's PUBG username.
     *
     * @param string $nickname PUBG username
     * @param string $season   Season (2017-pre1, 2017-pre2, 2017-pre3, 2017-pre4, 2017-pre5)
     * @param string $region   Region (na, eu, as, oc, sa, sea, krjp)
     * @param string $mode     Mode (solo, duo, squad, solo-fpp, duo-fpp, squad-fpp)
     * @param string $platform Platform, currently only pc
     *
     * @return object
     */
    public function getStatsByNickname(
        $nickname,
        $season = null,
        $region = null,
        $mode = null,
        $platform = 'pc'
    ) {
        $functionPath = $platform.'/'.$nickname;
        $query = [];
        if (!is_null($season)) {
            $query['season'] = $season;
        }
        if (!is_null($region)) {
            $query['region'] = $region;
        }
        if (!is_null($mode)) {
            $query['region'] = $region;
        }
        return $this->client->TRNrequest($functionPath, $query);
    }
}