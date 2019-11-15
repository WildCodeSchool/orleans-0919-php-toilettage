<?php

namespace App\Controller;

use App\Model\QuestionManager;
use App\Model\RaceManager;

class QuestionController extends AbstractController
{

    public function index()
    {
        $questionManager = new QuestionManager();
        $questions = $questionManager->selectAll();
        $raceManager = new RaceManager();
        $races = $raceManager->selectAll();
        return $this->twig->render('Question/index.html.twig', [
            'questions' => $questions,
            'races' => $races,
            ]);
    }
}
