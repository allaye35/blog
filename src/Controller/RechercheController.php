<?php

namespace App\Controller;

use App\Entity\MotsCles;
use App\Repository\MotsClesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    #[Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")]
    public function rechercherMotsCles(Request $request, MotsClesRepository $motsClesRepository): Response
    {
        $motsCle = new MotsCles();

        $lesMotsCles = [];

        if ($request->query->has('motsCles')) {
            $mot = $request->query->get('motsCles');

            $query = $motsClesRepository->createQueryBuilder('mc')
                ->where('mc.mot LIKE :mot')
                ->setParameter('mot', '%' . $mot . '%')
                ->getQuery();

            $lesMotsCles = $query->getResult();
        }

        return $this->render('recherche/index.html.twig', [
            'lesMotsCles' => $lesMotsCles,
        ]);
    }
}

