<?php

namespace App\Controller;

use App\Model\AnimalManager;
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
        $animalManager = new AnimalManager();
        $animals = $animalManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);

            if (empty($errors)) {
                $categoryManager = new CategoryManager();
                $categoryManager->insert($data);
                header('Location:/category/index');
            }
        }

        return $this->twig->render('Category/add.html.twig', [
            'errors' => $errors ?? [],
            'animals' => $animals
        ]);
    }

    public function edit(int $id): string
    {
        $catetogyManager = new CategoryManager();
        $category = $catetogyManager->selectOneById($id);
        $countRaces = $catetogyManager->countRacesInCategory($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $data['id'] = $category['id'];
            $errors = $this->validate($data);

            if (empty($errors)) {
                $catetogyManager->update($data);

                header('Location: /Category/index/');
            }
        }

        return $this->twig->render('Category/edit.html.twig', [
            'category' => $category,
            'errors' => $errors ?? [],
            'countRaces' => $countRaces
        ]);
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $catetogyManager = new CategoryManager();
            $catetogyManager->delete($id);
            header('Location: /Category/index');
        }
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
