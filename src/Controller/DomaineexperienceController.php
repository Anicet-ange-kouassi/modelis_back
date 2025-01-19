<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DomaineexperienceController extends AbstractController
{
    #[Route('/domaineexperience', name: 'app_domaineexperience')]
    public function index(): Response
    {
        return $this->render('domaineexperience/index.html.twig', [
            'controller_name' => 'DomaineexperienceController',
        ]);
    }
}
