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
            $uploadDir = 'uploads/';
            $data['image'] = $_FILES['path']['name'];


            $uploadDirBefore = 'uploads/before/';
            $data['before'] = $_FILES['path-before']['name'];

            $uploadDirAfter = 'uploads/after/';
            $data['after'] = $_FILES['path-after']['name'];

            $errors = $this->validate($data);

            $path = $this->validateUpload($_FILES['path']);
            $pathBefore = $this->validateUpload($_FILES['path-before']);
            $pathAfter = $this->validateUpload($_FILES['path-after']);

            if (empty($errors)) {
                if (!empty($path)) {
                    $fileName = $_FILES['path']['name'];
                    move_uploaded_file($_FILES['path']['tmp_name'], $uploadDir . $fileName);
                }
                if (!empty($pathBefore)) {
                    $fileNameBefore = $_FILES['path-before']['name'];
                    move_uploaded_file($_FILES['path-before']['tmp_name'], $uploadDirBefore . $fileNameBefore);
                }
                if (!empty($pathAfter)) {
                    $fileNameAfter = $_FILES['path-after']['name'];
                    move_uploaded_file($_FILES['path-after']['tmp_name'], $uploadDirAfter . $fileNameAfter);
                }
                $raceManager->update($data);
                header('Location:/race/index');
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



    public function validateUpload($image)
    {
        $errors = [];
        if ($image['error'] === 0) {
            $errors = "Fichier non ajouté";
        }
        if ($image['size'] > self::MAX_FILES_SIZE) {
            $errors = "Le fichier ne doit pas dépasser " . (self::MAX_FILES_SIZE / 1000) . "KO";
        }
        if (!in_array($image['type'], self::ALLOWED_MIMES)) {
            $errors = "Mauvais type de fichier, les fichier accepté sont "
                . implode(', ', self::ALLOWED_MIMES);
        }
        if (empty($errors)) {
            return $image;
        } else {
            return $errors;
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
            $data['image'] = $_FILES['path']['name'];


            $uploadDirBefore = 'uploads/before/';
            $data['before'] = $_FILES['path-before']['name'];

            $uploadDirAfter = 'uploads/after/';
            $data['after'] = $_FILES['path-after']['name'];

            $errors = $this->validate($data);

            $path = $this->validateUpload($_FILES['path']);
            $pathBefore = $this->validateUpload($_FILES['path-before']);
            $pathAfter = $this->validateUpload($_FILES['path-after']);
         
            if (empty($errors)) {
                if (!empty($path)) {
                    $fileName = $_FILES['path']['name'];
                    move_uploaded_file($_FILES['path']['tmp_name'], $uploadDir . $fileName);
                }
                if (!empty($pathBefore)) {
                    $fileNameBefore = $_FILES['path-before']['name'];
                    move_uploaded_file($_FILES['path-before']['tmp_name'], $uploadDirBefore . $fileNameBefore);
                }
                if (!empty($pathAfter)) {
                    $fileNameAfter = $_FILES['path-after']['name'];
                    move_uploaded_file($_FILES['path-after']['tmp_name'], $uploadDirAfter . $fileNameAfter);
                }
                $raceManager->insert($data);
                header('Location:/race/index');
            }
        }
        return $this->twig->render('Race/add.html.twig', [

            'data' => $data ?? [],
            'errors' => $errors ?? [],
            'categories' => $categories,
            'path' => $fileName ?? '',
            'path-before' => $fileNameBefore ?? '',
            'path-after' => $fileNameAfter ?? '',
        ]);
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $raceManager = new RaceManager();
            $race = $raceManager->selectOneById($id);
            $fileName = $race['image'];
            $fileNameBefore = $race['before'];
            $fileNameAfter = $race['after'];
            if ($race) {
                unlink('uploads/' . $fileName);
                unlink('uploads/before/' .$fileNameBefore);
                unlink('uploads/after/' .$fileNameAfter);
                $raceManager->delete($id);
            }
            header('Location: /Race/index');
        }
    }
}
