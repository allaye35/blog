<?php

namespace App\Controller;

use App\Entity\MotsCles;
use App\Form\MotsClesType;
use App\Repository\MotsClesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $motsCles = $motsClesRepository->findAll();
        $deleteForms = [];
        foreach ($motsCles as $motsCle) {
            $deleteForms[$motsCle->getId()] = $this->createDeleteForm($motsCle)->createView();
        }
        return $this->render('mots_cles/index.html.twig', [
            'mots_cles' => $motsCles,
            'delete_forms' => $deleteForms,
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
            'is_edit' => false,
        ]);
    }

    #[Route('/{id}', name: 'app_mots_cles_show', methods: ['GET'])]
    public function show(MotsCles $motsCle): Response
    {
        $deleteForm = $this->createDeleteForm($motsCle);

        return $this->render('mots_cles/show.html.twig', [
            'mots_cle' => $motsCle,
            'delete_form' => $deleteForm->createView(),
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

        $deleteForm = $this->createDeleteForm($motsCle);

        return $this->renderForm('mots_cles/edit.html.twig', [
            'mots_cle' => $motsCle,
            'form' => $form,
            'is_edit' => true,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_mots_cles_delete', methods: ['POST'])]
    public function delete(Request $request, MotsCles $motsCle, MotsClesRepository $motsClesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $motsCle->getId(), $request->request->get('_token'))) {
            $motsClesRepository->remove($motsCle, true);
        }

        return $this->redirectToRoute('app_mots_cles_index', [], Response::HTTP_SEE_OTHER);
    }

    private function createDeleteForm(MotsCles $motsCle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_mots_cles_delete', ['id' => $motsCle->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
