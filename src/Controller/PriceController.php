<?php

namespace App\Controller;

use App\Model\PriceManager;

class PriceController extends AbstractController
{

    public function index()
    {
        $animalManager = new PriceManager('animal');
        $animals = $animalManager->selectAll();

        $categoryManager = new PriceManager('category');
        $categories = $categoryManager->selectAll();

        $raceManager = new PriceManager('race');
        $races = $raceManager->selectAll();

        $showAnimal = [];

        if ($_GET) {
            $showAnimalManager = new PriceManager('race');
            $showAnimal = $showAnimalManager->selectOneById($_GET['id']);
        }

        return $this->twig->render('Price/index.html.twig', [
            'animals' => $animals,
            'categories' => $categories,
            'races' => $races,
            'showAnimal' => $showAnimal
        ]);
    }
}
