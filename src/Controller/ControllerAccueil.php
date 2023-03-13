<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ControllerAccueil extends AbstractController
{
    #[Route('/new/article', 'article_create')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        $article = new Article();
        // $article->setTitre('Pokéball');
        // $article->setDescription('Capturez un Pokémon grâce à cette Pokéball !');
        //  $article->setContenu('x1 Pokéball Classique');
        $article->setDateCreation(new \DateTime());
        $article->setCreePar($this->getUser());


        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$article` variable has also been updated
            $article = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_liste');
        }

        return $this->render('article/formArticle.html.twig', [
            'form_article' => $form,
        ]);
    }

    #[Route('/article/{id}', 'article_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {

        $article = $entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id ' . $id
            );
        }
        return $this->render('article/article_unique.html.twig', [
            'article' => $article,
        ]);
        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    #[Route('/liste-article', 'article_liste')]
    public function listeArticle(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Article::class);
        $articles = $repository->findAll();
        return $this->render('article/listeArticle.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/edit/{id}', 'article_modif')]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id ' . $id
            );
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $form->getData() holds the submitted values
            // but, the original `$article` variable has also been updated
            $article = $form->getData();


            // ... perform some action, such as saving the task to the database
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_liste');
        }

        return $this->render('article/formArticle.html.twig', [
            'form_article' => $form,
        ]);
    }

    #[Route('/delete-article/{id}', 'article_suppr')]
    public function supprimerArticle(EntityManagerInterface $entityManager, $id)
    {

        $article = $entityManager->getRepository(Article::class)->find($id);

        if ($this->getUser() ==  $article->getCreePar()) {
            $entityManager->remove($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_liste');
        } else {
            throw new AccessDeniedException('Vous n\'avez pas la permission de supprimer cet article');
        }
    }
}
