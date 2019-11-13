<?php
/**
 */

namespace App\Controller;

use App\Model\HomeManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $homeManager = new HomeManager();
        $races = $homeManager->selectAll();
        return $this->twig->render('Home/index.html.twig', ['races' => $races]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validateContact($data);

            if (empty($errors)) {
                header('Location: /Home/index/?success=ok#contact');
            }
        }

        return $this->twig->render('Home/index.html.twig', [
                'errors' => $errors ?? [],
                'success' => $_GET['success'] ?? null
            ]);
    }

    private function validateContact($data): array
    {
        $errors = [];
        if (empty($data['lastname'])) {
            $errors['lastname'] = "Veuillez remplir le champ nom";
        }
        if (empty($data['firstname'])) {
            $errors['firstname'] = "Veuillez remplir le champ prénom";
        }
        if (empty($data['mail'])) {
            $errors['mail'] = "Veuillez remplir le champ email";
        } elseif (!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] = "Format invalide d'email";
        }
        if (empty($data['message'])) {
            $errors['message'] = "Veuillez remplir le champ message";
        }

        return $errors;
    }

    public function send()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            if (empty($data['lastname'])) {
                $errors['lastname'] = "Veuillez remplir le champ nom";
            }
            if (empty($data['firstname'])) {
                $errors['firstname'] = "Veuillez remplir le champ prénom";
            }
            if (empty($data['mail'])) {
                $errors['mail'] = "Veuillez remplir le champ email";
            } elseif (!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
                $errors['mail'] = "Format invalide d'email";
            }
            if (empty($data['message'])) {
                $errors['message'] = "Veuillez remplir le champ message";
            }
            if (!empty($errors)) {
                return $this->twig->render('Home/index.html.twig', [
                    'errors' => $errors,]);
            } else {
                return $this->twig->render('Home/index.html.twig', [
                    'success' => true]);
            }
        }
    }
}
