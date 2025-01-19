<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SousespaceController extends AbstractController
{
    #[Route('/sousespace', name: 'app_sousespace')]
    public function index(): Response
    {
        return $this->render('sousespace/index.html.twig', [
            'controller_name' => 'SousespaceController',
        ]);
    }
}
