<?php

namespace App\Controller;

use App\Model\RaceManager;
use App\Model\CategoryManager;

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

    public function edit(int $id): string
    {
        $errors = [];
        $raceManager = new RaceManager();
        $race = $raceManager->selectOneById($id);

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);

            $errors = $this->validate($data);

            if (empty($errors)) {
                // update en bdd si pas d'erreur
                $raceManager->update($data);
                // redirection en GET
                header('Location: /Race/edit/' . $id);
            }
        }

        return $this->twig->render('Race/edit.html.twig', [
            'race' => $race,
            'data' => $data ?? [],
            'errors' => $errors,
            'categories' => $categories,
        ]);
    }

    private function validate(array $data): array
    {
        // verif coté serveur
        if (empty($data['name'])) {
            $errors['name'] = 'Veuillez entrer un nom';
        } elseif (strlen($data['name']) > 80) {
            $errors['name'] = 'le nom est trop long';
        }

        if (empty($data['price'])) {
            $errors['price'] = 'Un prix est requis';
        } elseif ($data['price'] < 0) {
            $errors['price'] = 'le prix doit être positif';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'Une description est requise';
        }

        return $errors ?? [];
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $raceManager = new RaceManager();
            $raceManager->delete($id);

            header('Location: /Race/index');
        }
    }
}
