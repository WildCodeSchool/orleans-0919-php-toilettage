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

    const MAX_FILES_SIZE = 100000;
    const ALLOWED_MIMES = ["image/jpeg", "image/png"];

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
            $uploadDir = '/uploads/';
            $data['image'] = $uploadDir . $_FILES['path']['name'];
            $errors = $this->validate($data);

            if (!empty($_FILES['path']['name'])) {
                $path = $_FILES['path'];

                if ($path['error'] !== 0) {
                    $errors[] = "Fichier non ajouté";
                }

                if ($path['size'] > self::MAX_FILES_SIZE) {
                    $errors[] = "Le fichier ne doit pas dépasser " . (self::MAX_FILES_SIZE / 1000) . "KO";
                }

                if (!in_array($path['type'], self::ALLOWED_MIMES)) {
                    $errors[] = "Mauvais type de fichier, les fichier accepté sont "
                        . implode(', ', self::ALLOWED_MIMES);
                }
            }
            if (empty($errors)) {
                if (!empty($path)) {
                    $fileName = $_FILES['path']['name'];

                    move_uploaded_file($_FILES['path']['tmp_name'], $uploadDir . $fileName);
                }
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

    public function add(): string
    {
        $raceManager = new RaceManager();
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $uploadDir = 'uploads/';
            $data['image'] = $uploadDir . $_FILES['path']['name'];
            $errors = $this->validate($data);

            if (!empty($_FILES['path']['name'])) {
                $path = $_FILES['path'];

                if ($path['error'] !== 0) {
                    $errors[] = "Fichier non ajouté";
                }

                if ($path['size'] > self::MAX_FILES_SIZE) {
                    $errors[] = "Le fichier ne doit pas dépasser " . (self::MAX_FILES_SIZE / 1000) . "KO";
                }

                if (!in_array($path['type'], self::ALLOWED_MIMES)) {
                    $errors[] = "Mauvais type de fichier, les fichier accepté sont "
                        . implode(', ', self::ALLOWED_MIMES);
                }
            }

            if (empty($errors)) {
                if (!empty($path)) {
                    $fileName = $_FILES['path']['name'];

                    move_uploaded_file($_FILES['path']['tmp_name'], $uploadDir . $fileName);
                }
                $raceManager->insert($data);
                header('Location:/race/index');
            }
        }


        return $this->twig->render('Race/add.html.twig', [
            'data' => $data ?? [],
            'errors' => $errors ?? [],
            'categories' => $categories,
            'path' => $fileName ?? ''
        ]);
    }
}
