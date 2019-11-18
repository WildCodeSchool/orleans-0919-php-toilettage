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

    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);

            if (empty($errors)) {
                $categoryManager = new CategoryManager();
                $categoryManager->insert($data);
                header('Location:/category/index');
            }
        }

        return $this->twig->render('Category/add.html.twig', ['errors' => $errors ?? []]);
    }

    private function validate(array $data): array
    {
        if (empty($data['category'])) {
            $errors['category'] = 'Veuillez entrer un nom de catégorie';
        } elseif (strlen($data['category']) > 80) {
            $errors['category'] = 'Ce nom de catégorie est trop long';
        }

        return $errors ?? [];
    }
}
