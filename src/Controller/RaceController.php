<?php

namespace App\Controller;

use App\Model\RaceManager;

/**
 * Class RaceController
 *
 */
class RaceController extends AbstractController
{
    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $raceManager = new RaceManager();
        $races = $raceManager->selectAllOrder();
        return $this->twig->render('Race/index.html.twig', ['races' => $races]);
    }
}