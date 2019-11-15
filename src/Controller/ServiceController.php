<?php

namespace App\Controller;

use App\Model\ServiceManager;
use App\Model\RaceManager;

/**
 * Class ServiceController
 *
 */
class ServiceController extends AbstractController
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
        $races = $raceManager->selectAll();
        return $this->twig->render('Service/index.html.twig', ['races' => $races]);
    }
}
