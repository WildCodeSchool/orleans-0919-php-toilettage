<?php

namespace App\Controller;

use App\Model\SalonManager;

/**
 * Class SalonController
 *
 */
class SalonController extends AbstractController
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
        return $this->twig->render('Salon/index.html.twig');
    }
}
