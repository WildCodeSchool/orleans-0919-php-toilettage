<?php

namespace App\Controller;

use App\Model\RaceManager;

class PricelistController extends AbstractController
{

    const STRAIGHTENING_PRICE = 50;

    public function index($raceId = null)
    {

        $animalManager = new RaceManager();
        $allInAnimals = $animalManager->selectAllInAnimals();


        foreach ($allInAnimals as $animal) {
            $groupedAnimals[$animal['animal']][$animal['category']][] =
                ['race_name' => $animal['race_name'], 'id' => $animal['id'], 'price' => $animal['price']];
        }

        if ($raceId) {
            $raceManager = new RaceManager();
            $race = $raceManager->selectOneById($raceId);
            $straighteningPrice = $race['price'] + self::STRAIGHTENING_PRICE;
        }

        return $this->twig->render('Pricelist/index.html.twig', [
            'groupedAnimals' => $groupedAnimals ?? [],
            'race' => $race ?? ['price' => '--'],
            'straighteningPrice' => $straighteningPrice ?? '--'
        ]);
    }
}
