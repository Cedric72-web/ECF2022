<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Module;
use App\Entity\Franchise;
use App\Entity\Partner;
use App\Form\NewUserType;
use App\Form\NewModuleType;
use App\Form\NewFranchiseType;
use App\Form\EditFranchiseType;
use App\Form\NewPartnerType;
use App\Repository\UserRepository;
use App\Repository\ModuleRepository;
use App\Repository\PartnerRepository;
use App\Repository\FranchiseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    // *** FRANCHISES ***

    #[Route('/franchises', name: 'franchises')]
    public function listFranchises(FranchiseRepository $franchisesRepo, PartnerRepository $partnerRepo): Response
    {
        return $this->render("admin/franchises.html.twig", [
            'franchises' => $franchisesRepo->findAll(),
            'partners' => $partnerRepo->findAll()
        ]);
    }

    #[Route('/franchise/new', name: 'nouvelle_franchise')]
    public function newFranchise(Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine):Response
    {
        $franchise = new Franchise($userPasswordHasher);

        $form = $this->createForm(NewFranchiseType::class, $franchise);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($franchise);
            $entityManager->flush();

            return $this->redirectToRoute("admin_franchises");
        }
        return $this->render('admin/newfranchise.html.twig', [
            "form" => $form->createview(),
        ]);        
    }

    #[Route('/franchise/view/{id}', name: 'voir_franchise')]
    public function viewFranchise(Franchise $franchise, PartnerRepository $repository, Request $request)
    {
        $status = $request->request->get('choicePartner');
        if ($status) {
            $partners = $repository->findByStatus($status);
        }
        $partners = $repository->findById($franchise);
        return $this->render('admin/viewfranchise.html.twig', [
            'franchise' => $franchise,
            'partners' => $partners
        ]);
    }
    
    #[Route('/franchise/edit/{id}', name: 'modifier_franchise')]
    public function editFranchise(Franchise $franchise, Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(EditFranchiseType::class, $franchise);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($franchise);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_franchise');
        }

        return $this->render('admin/editfranchise.html.twig', [
            'franchiseForm' =>$form->createView()
        ]);
    }

    #[Route('/franchise/delete/{id}', name: 'supprimer_franchise')]
    public function deleteFranchise(Franchise $franchise, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($franchise);
        $entityManager->flush();
        return $this->redirectToRoute(('admin_franchise'));
    }

    // *** UTILISATEURS ***
    
    #[Route('/users', name: 'utilisateurs')]
    public function listUsers(UserRepository $users): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    #[Route('user/new', name: 'nouvel_utilisateur')]
    public function newUser(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher):Response
    {
        $user = new User($userPasswordHasher);

        $form = $this->createForm(NewUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $username = $user->getLastname() . " " . $user->getFirstname();
            $user->setUsername($username);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute("admin_utilisateurs");
        }
        return $this->render('admin/newuser.html.twig', [
            "form" => $form->createview(),
        ]);        
    }
    
    // *** SALLES ***
    
    #[Route('/partners', name: 'salles')]
    public function listPartners(PartnerRepository $partners): Response
    {
        return $this->render('admin/partners.html.twig', [
            'partners' => $partners->findAll(),
        ]);
    }

    #[Route('/partner/new', name:'nouvelle_salle')]
    public function newPartner(UserPasswordHasherInterface $userPasswordHasher, Request $request, ManagerRegistry $doctrine)
    {
        $partner = new Partner($userPasswordHasher);

        $form = $this->createForm(NewPartnerType::class, $partner);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute("admin_salles");
        }
        return $this->render('admin/newpartner.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // *** MODULES ***
    #[Route('/modules', name: 'modules')]
    public function listModules(ModuleRepository $modules) : Response
    {
        return $this->render('admin/modules.html.twig', [
            'modules' => $modules->findAll(),
        ]);
    }

    #[Route('module/new', name: 'nouveau_module')]
    public function newModule(Request $request, ManagerRegistry $doctrine):Response
    {
        $module = new Module;

        $form = $this->createForm(NewModuleType::class, $module);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute("admin_modules");
        }
        return $this->render('admin/newmodule.html.twig', [
            "form" => $form->createview(),
        ]);        
    }
}
