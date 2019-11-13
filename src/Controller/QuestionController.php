<?php

namespace App\Controller;

use App\Model\QuestionManager;

class QuestionController extends AbstractController
{

    public function index()
    {
        $questionManager = new QuestionManager();
        $questions = $questionManager->selectAll();

        return $this->twig->render('Question/index.html.twig', ['questions' => $questions]);
    }
}
