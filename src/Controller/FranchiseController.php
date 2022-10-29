<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FranchiseController extends AbstractController
{
    #[Route('/franchise', name: 'franchise')]
    public function index(): Response
    {
        return $this->render('franchise/index.html.twig', [
            'controller_name' => 'FranchiseController',
        ]);
    }
}
