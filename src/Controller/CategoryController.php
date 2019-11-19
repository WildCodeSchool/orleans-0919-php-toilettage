<?php

namespace App\Controller;

use App\Model\CategoryManager;

/**
 * Class CategoryController
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
    public function index($id)
    {
        $categoryManager = new CategoryManager($id);
        $categories = $categoryManager->selectCountByCategory();

        return $this->twig->render('Category/index.html.twig', ['categories' => $categories]);
    }

    /**
     *deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $categoryManager = new categoryManager($id);
        $categoryManager->delete($id);

        header('Location:/category/index/');
    }

}