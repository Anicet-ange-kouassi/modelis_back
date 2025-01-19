<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ValeurController extends AbstractController
{
    #[Route('/valeur', name: 'app_valeur')]
    public function index(): Response
    {
        return $this->render('valeur/index.html.twig', [
            'controller_name' => 'ValeurController',
        ]);
    }
}
