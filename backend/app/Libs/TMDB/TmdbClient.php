<?php

namespace App\Libs\TMDB;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TmdbClient
{
    private string $endpoint = 'https://api.themoviedb.org/3/';

    private static $instance = null;

    private $client;

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->endpoint,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.config('tmdb.api_key'),
            ],
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function searchMovie($text, $page = 1)
    {
        return $this->request('GET', 'search/movie', ['query' => $text, 'page' => $page]);
    }

    public function fetchGenres()
    {
        return $this->request('GET', 'genre/movie/list');
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function request($method, $path, $params = null)
    {
        try {
            $response = $this->client->request($method, $path, ['query' => $params]);

            return static::handleResponse($response);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public static function handleResponse($response)
    {
        return json_decode($response->getBody(), true);
    }
}
