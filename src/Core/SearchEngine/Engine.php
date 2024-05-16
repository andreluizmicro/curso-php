<?php

declare(strict_types=1);

namespace Core\SearchEngine;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Engine
{
    public function __construct(
        public Client $client,
        public Crawler $crawler
    ) {
    }

    public function search(string $url): array
    {
        $response = $this->client->request('GET', $url);

        $html = $response->getBody();

        $this->crawler->addHtmlContent((string) $html);

        $elements = $this->crawler->filter('span.card-curso__nome');
        $courses = [];

        foreach ($elements as $element) {
            $courses[] = $element->textContent;
        }
        return $courses;
    }
}
