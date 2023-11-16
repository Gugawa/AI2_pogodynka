<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        WeatherUtil $util,
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter] bool $twig = false,
    ): Response
    {
        $measurements = $util->getWeatherForCountryAndCity($country, $city);

        if($format === 'csv'){
            if($twig){
                return $this->render('weather_api/index.csv.twig', [
                    'country' => $country,
                    'city' => $city,
                    'measurements' => $measurements,
                ]);
            } else {
                $csv = "country, city, date, celsius\n";
                $csv .= implode(
                    "\n",
                    array_map(fn(Measurement $m) => sprintf(
                        "%s, %s, %s, %s",
                        $country,
                        $city,
                        $m->getDate()->format("Y-m-d"),
                        $m->getCelsius(),
                        $m->getFahrehneit(),
                    ), $measurements)
                );

                return new Response($csv, 200);
            }
        }

        if($twig){
            return $this->render('weather_api/index.json.twig', [
                'country' => $country,
                'city' => $city,
                'measurements' => $measurements,
            ]);
        }
        return $this->json([
            'country' => $country,
            'city' => $city,
            'measurements' => array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'celsius' => $m->getCelsius(),
                'fahrenheit' => $m->getFahrehneit(),
            ], $measurements),
        ]);
    }
}
