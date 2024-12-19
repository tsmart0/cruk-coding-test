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
        $cache = new FilesystemAdapter(directory: $this->getParameter('kernel.cache_dir'));
        $data = $cache->get('forecast', function (ItemInterface $item): string {
            $item->expiresAfter(300);
            $client = HttpClient::create();
            $response = $client->request(
                'GET',
                'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m&hourly=temperature_2m&forecast_days=1'
            );
            return $response->getContent();
        });
        return new Response($data);
    }
}