<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MotsCles;
use App\Repository\MotsClesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Repository\CommentaireRepository;
use App\Entity\Commentaire;
use App\Form\CommentaireType;

use Symfony\Component\Security\Core\Security as UserSecurity;

#[Route('/article')]
#[Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $deleteForms = [];

        foreach ($articles as $article) {
            $deleteForms[$article->getId()] = $this->createDeleteForm($article)->createView();
        }

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'delete_forms' => $deleteForms,
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $articleRepository, MotsClesRepository $motsClesRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des mots-clés du formulaire
            $motsCles = $form->get('motsCles')->getData();
            $nouveauMotCle = $form->get('nouveauMotCle')->getData();

            // Ajouter les mots-clés existants à l'article
            foreach ($motsCles as $motCle) {
                $article->addMotsCle($motCle);
            }

            // Ajouter un nouveau mot-clé s'il est renseigné
            if (!empty($nouveauMotCle)) {
                $motCle = new MotsCles();
                $motCle->setMot($nouveauMotCle);
                $motsClesRepository->save($motCle, true);
                $article->addMotsCle($motCle);
            }

            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Article $article, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $comment_form = $this->createForm(CommentaireType::class, $commentaire);
        $comment_form->handleRequest($request);

        if ($comment_form->isSubmitted() && $comment_form->isValid()) {
            // Associer l'utilisateur connecté au commentaire
            /** @var Utilisateur $user */
            $user = $this->getUser();
            $commentaire->setUtilisateur($user);
            $commentaire->setArticle($article);
            $commentaireRepository->save($commentaire, true);

            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
        }

        $delete_form = $this->createDeleteForm($article);

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'delete_form' => $delete_form->createView(),
            'comment_form' => $comment_form->createView(),
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

    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_article_delete', ['id' => $article->getId()]))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => 'Supprimer',
                'attr' => ['class' => 'btn btn-danger']
            ])
            ->getForm();
    }
}