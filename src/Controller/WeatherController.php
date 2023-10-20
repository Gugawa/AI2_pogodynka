<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{country?}', name: 'app_weather')]
    public function city(string $city, ?string $country, LocationRepository $locationRepository, MeasurementRepository $measurementRepository): Response
    {
        $locationCriteria = ['city' => $city];
        if ($country) {
            $locationCriteria['country'] = $country;
        }

        $location = $locationRepository->findOneBy($locationCriteria);

        if (!$location) {
            throw $this->createNotFoundException('No location found for provided city and country');
        }

        $measurements = $measurementRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
