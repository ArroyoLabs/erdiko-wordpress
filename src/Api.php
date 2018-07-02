<?php
/**
 * Wordpress Api
 * Base model every Wordpress model should inherit
 *
 * @package   	erdiko\wordpress
 * @copyright 	Copyright (c) 2018, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress;

use GuzzleHttp\Client;

class Api
{
	protected $apiUrl;
	protected $client;
	protected $settings;

	public function __construct($settings)
	{
		if( empty( $settings['api_url'] ) )
			throw new \Exception("WordPress API settings requires api_url");

		$this->apiUrl = $settings['api_url'];

		if( empty( $settings['options'] ) )
			$this->client = new Client();
		else
			$this->client = new Client( $settings['options'] );
		
		$this->settings = $settings;
	}

	/**
	 * Get the WP config settings
	 * @return array $settings
	 */
	public function getSettings()
	{
		return $this->settings;
	}

	public function getUrl($uri)
	{
		return $this->apiUrl . '/' . $uri;
	}

	public function get($uri, $getUrl = true) {
		try {
			$url = ($getUrl) ? $this->getUrl($uri) : $uri;
			$response = $this->client->get( $url );
			$result = json_decode( $response->getBody()->getContents() );
			return $result;

		} catch (\GuzzleHttp\Exception\RequestException $e) {
			$this->errorHandler($e);

		} catch (\Exception $e) {
			$this->errorHandler($e);
		}
		// @todo return a message or throw an \erdiko\wordpress exception if it failed
	}

	public function errorHandler($e)
	{
		error_log("error: ".$e->getMessage());
		// @todo log to logger
	}
}
