<?php

namespace App\Controller;

use App\Model\RaceManager;
use App\Model\CategoryManager;

/**
 * Class RaceController
 *
 */
class CategoryController extends AbstractController
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
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAllOrder();
        return $this->twig->render('Category/index.html.twig', ['categories' => $categories]);
    }
}
