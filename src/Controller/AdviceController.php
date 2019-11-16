<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\RaceManager;

/**
 * Class AdviceController
 *
 */
class AdviceController extends AbstractController
{
    public function show($id)
    {
        $raceManager = new RaceManager();
        $race = $raceManager->selectOneById($id);
        $animalManager = new RaceManager();
        $allInAnimals = $animalManager->selectAllInAnimals();

        foreach ($allInAnimals as $animal) {
            $groupedAnimals[$animal['animal']][$animal['category']][] =
                ['race_name' => $animal['race_name'], 'animal_id' => $animal['id']];
        }

        return $this->twig->render('Advice/show.html.twig', [
            'groupedAnimals' => $groupedAnimals ?? [],
            'race' => $race ?? []
        ]);
    }
}
