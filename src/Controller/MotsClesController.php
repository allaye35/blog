<?php

namespace App\Controller;

use App\Entity\MotsCles;
use App\Form\MotsClesType;
use App\Repository\MotsClesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


#[Route('/mots/cles')]
#[Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")]

class MotsClesController extends AbstractController
{
    #[Route('/', name: 'app_mots_cles_index', methods: ['GET'])]
    public function index(MotsClesRepository $motsClesRepository): Response
    {
        return $this->render('mots_cles/index.html.twig', [
            'mots_cles' => $motsClesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mots_cles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MotsClesRepository $motsClesRepository): Response
    {
        $motsCle = new MotsCles();
        $form = $this->createForm(MotsClesType::class, $motsCle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $motsClesRepository->save($motsCle, true);

            return $this->redirectToRoute('app_mots_cles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mots_cles/new.html.twig', [
            'mots_cle' => $motsCle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mots_cles_show', methods: ['GET'])]
    public function show(MotsCles $motsCle): Response
    {
        return $this->render('mots_cles/show.html.twig', [
            'mots_cle' => $motsCle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mots_cles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MotsCles $motsCle, MotsClesRepository $motsClesRepository): Response
    {
        $form = $this->createForm(MotsClesType::class, $motsCle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $motsClesRepository->save($motsCle, true);

            return $this->redirectToRoute('app_mots_cles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mots_cles/edit.html.twig', [
            'mots_cle' => $motsCle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mots_cles_delete', methods: ['POST'])]
    public function delete(Request $request, MotsCles $motsCle, MotsClesRepository $motsClesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$motsCle->getId(), $request->request->get('_token'))) {
            $motsClesRepository->remove($motsCle, true);
        }

        return $this->redirectToRoute('app_mots_cles_index', [], Response::HTTP_SEE_OTHER);
    }
}
