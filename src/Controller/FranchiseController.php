<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Repository\PartnerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FranchiseController extends AbstractController
{
    #[Route('/franchise', name: 'franchise')]
    public function index(Franchise $franchise, PartnerRepository $partnerRepo, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $franchise = $doctrine->getRepository(Franchise::class);
        return $this->render('franchise/index.html.twig', [
            'controller_name' => 'FranchiseController',
            'user' => $user,
        ]);
    }
}
