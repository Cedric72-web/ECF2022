<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Partner;
use App\Entity\Franchise;
use App\Form\NewUserType;
use App\Form\EditUserType;
use App\Form\NewModuleType;
use App\Form\NewPartnerType;
use App\Form\NewFranchiseType;
use App\Form\EditFranchiseType;
use App\Form\EditPartnerType;
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
    public function index(UserRepository $userRepo, FranchiseRepository $franchisesRepo, PartnerRepository $partnersRepo, ModuleRepository $modulesRepo): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => count($userRepo->findAll()),
            'franchises' => count($franchisesRepo->findAll()),
            'partners' => count($partnersRepo->findAll()),
            'modules' => count($modulesRepo->findAll()),
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
    public function editFranchise(Franchise $franchise, Request $request, ManagerRegistry $doctrine, $id)
    {
        $franchise = $doctrine->getRepository(Franchise::class);
        $franchise = $franchise->find($id);

        $form = $this->createForm(EditFranchiseType::class, $franchise);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($franchise);
            $entityManager->flush();

            $this->addFlash('message', 'Franchise modifiée avec succès');
            return $this->redirectToRoute('admin_franchises');
        }

        return $this->render('admin/editfranchise.html.twig', [
            'franchiseForm' =>$form->createView()
        ]);
    }

    #[Route('/franchise/delete/{id}', name: 'supprimer_franchise')]
    public function deleteFranchise(Franchise $franchise, ManagerRegistry $doctrine, $id): Response
    {
        $franchise = $doctrine->getRepository(Franchise::class);
        $franchise = $franchise->find($id);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($franchise);
        $entityManager->flush();

        $this->addFlash('message', 'Franchise supprimée avec succès');
        return $this->redirectToRoute(('admin_franchises'));
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

            $this->addFlash('message', 'Utilisateur ajouté avec succès');
            return $this->redirectToRoute("admin_utilisateurs");
        }
        return $this->render('admin/newuser.html.twig', [
            "form" => $form->createview(),
        ]);        
    }

    #[Route('user/edit/{id}', name:'modifier_utilisateur')]
    public function editUser(Request $request, ManagerRegistry $doctrine, User $user, $id)
    {
        $user = $doctrine->getRepository(User::class);
        $user = $user->find($id);

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form ->isValid())
        {
            $username = $user->getLastname() . " " . $user->getFirstname();
            $user->setUsername($username);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute("admin_utilisateurs");
        }
        return $this->render('admin/edituser.html.twig', [
            "userForm" => $form->createview(),
        ]); 
    }
    
    #[Route('/user/delete/{id}', name: 'supprimer_utilisateur')]
    public function deleteUser(User $user, ManagerRegistry $doctrine, $id): Response
    {
        $user = $doctrine->getRepository(User::class);
        $user = $user->find($id);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('message', 'Utilisateur supprimé avec succès');
        return $this->redirectToRoute(('admin_utilisateurs'));
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
    
    #[Route('partner/edit/{id}', name:'modifier_salle')]
    public function editPartner(Request $request, ManagerRegistry $doctrine, Partner $partner, $id)
    {
        $partner = $doctrine->getRepository(Partner::class);
        $partner = $partner->find($id);

        $form = $this->createForm(EditPartnerType::class, $partner);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form ->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            $this->addFlash('message', 'Salle modifiée avec succès');
            return $this->redirectToRoute("admin_salles");
        }
        return $this->render('admin/editpartner.html.twig', [
            "partnerForm" => $form->createview(),
        ]); 
    }
    
    #[Route('/partner/delete/{id}', name: 'supprimer_salle')]
    public function deletePartner(Partner $partner, ManagerRegistry $doctrine, $id): Response
    {
        $partner = $doctrine->getRepository(Partner::class);
        $partner = $partner->find($id);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($partner);
        $entityManager->flush();
        
        $this->addFlash('message', 'Salle supprimée avec succès');
        return $this->redirectToRoute(('admin_salles'));
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
    
    #[Route('/user/module/{id}', name: 'supprimer_module')]
    public function deleteModule(Module $module, ManagerRegistry $doctrine, $id): Response
    {
        $module = $doctrine->getRepository(User::class);
        $module = $module->find($id);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($module);
        $entityManager->flush();
        
        $this->addFlash('message', 'Module supprimé avec succès');
        return $this->redirectToRoute(('admin_utilisateurs'));
    }
}
