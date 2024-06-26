<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\RoleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Route('/utilisateur')]
#[Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")]

class UtilisateurController extends AbstractController
{
    #[Route('/', name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface $passwordHasher, RoleRepository $roleRepository): Response
    {
        // Création d'un nouvel utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->setDateCreationUtilisateur(new \DateTime());
        // Création et gestion du formulaire
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement des données du formulaire validé
            $this->handleValidForm($utilisateur, $passwordHasher, $roleRepository);

            // Sauvegarde de l'utilisateur dans la base de données
            $utilisateurRepository->save($utilisateur, true);

            // Redirection après la sauvegarde réussie
            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire
        return $this->renderForm('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
            'is_edit' => false,
        ]);
    }

    private function handleValidForm(Utilisateur $utilisateur, UserPasswordHasherInterface $passwordHasher, RoleRepository $roleRepository): void
    {
        // Définition de la date de création de l'utilisateur
        $utilisateur->setDateCreation(new \DateTime());
        $utilisateur->setDateCreationUtilisateur(new \DateTime());

        // Hachage du mot de passe de l'utilisateur
        $hashedPassword = $passwordHasher->hashPassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hashedPassword);

        // Attribution du rôle par défaut à l'utilisateur
        $role = $roleRepository->findOneBy(['description' => 'ROLE_USER']);
        $utilisateur->addRole($role);
    }


    #[Route('/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateurRepository->save($utilisateur, true);

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
            'is_edit' => false,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateurRepository->remove($utilisateur, true);
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
