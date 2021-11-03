<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/", name="backoffice_main")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="backoffice_main_show", methods={"GET"})
     */
    public function show(): Response
    {
        return $this->render('backoffice/main/index.html.twig');
    }
}
