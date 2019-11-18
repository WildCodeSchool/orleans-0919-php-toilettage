<?php
/**
 */

namespace App\Controller;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validateContact($data);

            if (empty($errors)) {
                if (empty($errors)) {
                    $transport = Transport::fromDsn(MAIL_DSN);
                    $mailer = new Mailer($transport);
                    $email = (new Email())
                        ->from(MAIL_FROM)
                        ->to(MAIL_TO)
                        ->subject('Site toilettage séduction : contact')
                        ->html($this->twig->render('Email/index.html.twig', [
                            'data' => $data,
                        ]));
                    $mailer->send($email);
                }
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
}
