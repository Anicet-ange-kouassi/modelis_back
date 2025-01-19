<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TypeoffreController extends AbstractController
{
    #[Route('/typeoffre', name: 'app_typeoffre')]
    public function index(): Response
    {
        return $this->render('typeoffre/index.html.twig', [
            'controller_name' => 'TypeoffreController',
        ]);
    }
}
