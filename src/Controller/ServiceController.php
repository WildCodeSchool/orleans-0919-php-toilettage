<?php

namespace App\Controller;
use App\Model\ItemManager;
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
        return $this->twig->render('Service/index.html.twig');
    }
}
