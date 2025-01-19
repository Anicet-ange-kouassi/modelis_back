<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NosmetiersController extends AbstractController
{
    #[Route('/nosmetiers', name: 'app_nosmetiers')]
    public function index(): Response
    {
        return $this->render('nosmetiers/index.html.twig', [
            'controller_name' => 'NosmetiersController',
        ]);
    }
}
