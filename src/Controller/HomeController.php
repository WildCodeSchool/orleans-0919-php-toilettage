<?php
/**
 */

namespace App\Controller;

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
        return $this->twig->render('Home/index.html.twig');
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
