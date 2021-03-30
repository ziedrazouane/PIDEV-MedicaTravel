<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use App\Form\CategorieType;
use App\Repository\ArticleRepository;

use App\Repository\CategorieRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo): Response
    {

        $articles = $repo->findAll();

        return $this->render('blog/Front/Blog.html.twig', [
            'controller_name' => 'BlogController','articles'=>$articles
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        return $this->render('blog/Front/show.html.twig',['article'=>$article]);
    }

    /**
     * @Route("/BackBlog", name="BackBlog")

     */
    public function BackBlogAction(ArticleRepository $repo,CategorieRepository $repo1)
    {
        $categories =$repo1->findAll();
        $articles = $repo->findAll();
        return $this->render('blog/Back/BlogBack.html.twig',['articles'=>$articles,'categories'=>$categories]);
    }

    /**
     * @Route("/Remove/{id}", name="Supprimer" )

     */


    public function removeArticleAction(Article $article)
    {

        $em=$this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("BackBlog");

    }

    /**
     * @Route("/RemoveCat/{id}", name="SupprimerCat" )

     */


    public function removeCatAction(Categorie $categorie)
    {

        $em=$this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("BackBlog");

    }

    /**
     * @Route("/BackBlog/new", name="Article_new")
     * @Route ("/BackBlog/{id}/edit",name="Blog_edit")
     */
    public function create(Article $article = null,Request $request)
    {
if(!$article) {
    $article = new  Article();
}
            $form=$this->createForm(ArticleType::class,$article);
            $form->handleRequest($request) ;

            if ($form->isSubmitted()&& $form->isValid())
            {
                if($article->getId()) {
                    $article->setDate(new \DateTime());
                }

            $manager=$this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();
            //$this->redirectToRoute('blogBack_show', ['id' => $article->getId()]);
            return $this->redirectToRoute('BackBlog');

          }

        return $this->render('blog/Back/CreateArticle.html.twig',['formArticle'=>$form->createView(),'editMode'=>$article->getId()!==null]);
    }

    /**
     * @Route("/BackBlog/newCat", name="Cat_new")
     * @Route ("/BackBlog/{id}/edit_Cat",name="Cat_edit")
     */

    public function createCat(Categorie $cat = null,Request $request)
    {
        if(!$cat) {
            $cat = new  Categorie();
        }
        $form=$this->createForm(CategorieType::class,$cat);
        $form->handleRequest($request) ;

        if ($form->isSubmitted()&& $form->isValid())
        {


            $manager=$this->getDoctrine()->getManager();
            $manager->persist($cat);
            $manager->flush();
            //$this->redirectToRoute('blogBack_show', ['id' => $article->getId()]);
            return $this->redirectToRoute('BackBlog');

        }

        return $this->render('blog/Back/CreateCat.html.twig',['formCat'=>$form->createView(),'editMode'=>$cat->getId()!==null]);
    }





}

