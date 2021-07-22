<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AthleteController extends AbstractController
{
    #[Route('/athlete', name: 'athlete')]
    public function index(): Response
    {
        return $this->render('athlete/index.html.twig', [
            'controller_name' => 'AthleteController',
        ]);
    }
}
