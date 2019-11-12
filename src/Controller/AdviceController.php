<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\AdviceManager;

/**
 * Class AdviceController
 *
 */
class AdviceController extends AbstractController
{
    public function show(int $id)
    {   $race=[];
        $adviceManager = new AdviceManager();
        $race = $adviceManager->selectOneById($id);
        return $this->twig->render('Advice/show.html.twig', ['race' => $race]);
    }
}
