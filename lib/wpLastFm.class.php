<?php
class wpLastFm
{
  private $http_status;
  private $last_api_call;
  private $lastfm_api_key;
  private $lastfm_username;
  
  protected $lastfm_api_address = 'http://ws.audioscrobbler.com/2.0/?method=';

  public function __construct($username = null)
  {
    if(is_null($username)) {
      $this->setLastFmUsername(sfConfig::get('app_wp_lastfm_username'));
    } else {
      $this->setLastFmUsername($username);
    }
    $this->setLastFmApiKey(sfConfig::get('app_wp_lastfm_api_key'));
  }

  private function getLastFmApiKey()
  {
    return $this->lastfm_api_key;
  }

  private function setLastFmApiKey($value)
  {
    $this->lastfm_api_key = $value;
  }

  private function getLastFmUsername()
  {
    return $this->lastfm_username;
  }

  private function setLastFmUsername($value)
  {
    $this->lastfm_username = $value;
  }
  
  private function getLastFmApiAddress()
  {
    return $this->lastfm_api_address;
  }

  /**
   * Debug helpers
   */
  public function lastStatusCode() {
    return $this->http_status;
  }

  public function lastAPICall() {
    return $this->last_api_call;
  }

  public function get($method, $parameters = null)
  {
    $params = '';
    // If there are any parameters we add them to the URL
    if (is_array($parameters)) {
      foreach($parameters AS $key => $value) {
        $params .= '&' . $key . '=' . $value;
      }
    }
    return $this->http($this->getLastFmApiAddress() . $method . '&user=' . $this->getLastFmUsername() . '&api_key=' . $this->getLastFmApiKey() . $params);
  }

  /**
   * Make an HTTP request
   *
   * @return API results
   */
  private function http($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec($ch);
    
    $this->http_status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $this->last_api_call = $url;

    curl_close ($ch);

    return simplexml_load_string($response);
  }
}
