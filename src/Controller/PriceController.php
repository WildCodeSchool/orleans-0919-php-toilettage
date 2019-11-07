<?php


namespace App\Controller;

use App\Model\PriceManager;

class PriceController extends AbstractController
{

    public function index($raceId = null)
    {

        $animalManager = new PriceManager('animal');
        $animals = $animalManager->selectAll();

        $categoryManager = new PriceManager('category');
        $categories = $categoryManager->selectAll();

        $raceManager = new PriceManager('race');
        $races = $raceManager->selectAll();

        if ($raceId) {
            $showAnimalManager = new PriceManager('race');
            $race = $showAnimalManager->selectOneById($raceId);
        }

        return $this->twig->render('Price/index.html.twig', [
            'animals' => $animals,
            'categories' => $categories,
            'races' => $races,
            'race' => $race ?? []
        ]);
    }
}
