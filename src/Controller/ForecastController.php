<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpClient\HttpClient;

class ForecastController extends AbstractController
{
    #[Route('/forecast')]
    public function forecast(): Response
    {
        /*
         * This will check the local file system for the cached forecast data from the API.
         * If there is a cache miss (ie. it is null or older than 5 minutes) then a request is sent to open meteo to retrieve fresh data and update the local cache.
         */
        $cache = new FilesystemAdapter(directory: $this->getParameter('kernel.cache_dir'));
        $data = $cache->get('forecast', function (ItemInterface $item): string {
            $item->expiresAfter(300);
            // I used the Symfony HTTP client to send a request to the API.
            $client = HttpClient::create();
            // In the endpoint the parameters are hard-coded. Perhaps the front-end application would need to pass in different parameters, but that wasn't specified.
            $response = $client->request(
                'GET',
                'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m&hourly=temperature_2m&forecast_days=1'
            );
            return $response->getContent();
        });
        // Returning the data as-is from the API or cache as JSON.
        return new Response(
            content: $data,
            headers: ['Content-Type' => 'application/json; charset=utf-8']
        );
    }
}