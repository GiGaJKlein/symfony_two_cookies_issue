<?php

namespace App\Tests;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\RequestOptions;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\Client;

class TestForBug extends WebTestCase
{

    function testTwoSetCookiesForPhpsessid()
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8001',
            'http_errors' => false,
            'cookies' => true
        ]);

        $jar = new CookieJar();

        $response = $client->request('GET', '/login', [
            RequestOptions::JSON => [
                'user' => 'testuser',
                'password' => 'test',
            ],
            'cookies' => $jar,
            'allow_redirects' => false
        ]);

        $cookie = $jar->getCookieByName('PHPSESSID');
        $this->assertEquals("PHPSESSID", $cookie->getName());

        $this->assertEquals(200, $response->getStatusCode());

        $response = $client->request("GET", "/logout", [
            'cookies' => $jar,
            'allow_redirects' => false
        ]);

        $cookie = $jar->getCookieByName('PHPSESSID');
        $this->assertEquals("PHPSESSID", $cookie->getName());

        $headersStr = "";
        foreach ($response->getHeaders() as $name => $headers) {
            $headersStr .= $name . ": " . implode(", ", $headers);
        }

        $this->assertEquals(2, substr_count($headersStr, "PHPSESSID=delete"));
    }
}