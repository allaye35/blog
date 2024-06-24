<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MotsCles;
use App\Repository\MotsClesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


#[Route('/article')]
#[Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $articleRepository,MotsClesRepository $motsClesRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur courant
            $user = $this->getUser();
            // Vérifier que l'utilisateur est connecté
            if (!$user) {
                // Rediriger ou afficher un message d'erreur approprié
                $this->addFlash('error', 'Vous devez être connecté pour créer un article.');
                return $this->redirectToRoute('app_login');
            }

            // Associer l'utilisateur courant à l'article
            $article->setUtilisateur($user);

            $article->setUtilisateur($this->getUser());
            // Associer l'email de l'utilisateur courant à l'article
            $email = $user->getEmail();
            $article->setEmail($email);
//            $article->addUtilisateur($this->getUser());
            $article->setDateCreation(new \DateTime());
            $motsCles = explode(',', $article->getMotsCles());
            foreach ($motsCles as $mots) {
                // Vérifier si le mot existe déjà dans la base de données
                $motExistant = $motsClesRepository->findOneBy(['mot' => $mots]);
                if (!$motExistant) {
                    // Si le mot n'existe pas, créez un nouvel objet Mot et enregistrez-le dans la base de données
                    $nouveauMot = new MotsCles();
                    $nouveauMot->setMot($mots);
                    $motsClesRepository->save($nouveauMot,true);
                    $article->addMotsCle($nouveauMot);

                }
            }
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
