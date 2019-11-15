<?php

namespace App\Controller;

use App\Model\ItemManager;

class PartnerController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('Partner/index.html.twig');
    }
}
