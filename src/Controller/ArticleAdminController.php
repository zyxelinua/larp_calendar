<?php
namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;

class ArticleAdminController extends BaseController
{
    const ITEMS_PER_PAGE_ADMIN = 10;

    /**
     * @Route("/admin/article/list", name="admin_list_articles")
     * @Template("admin/article/list.html.twig")
     */
    public function listArticlesAdmin(Request $request, ArticleRepository $articleRepository)
    {
        $page = $request->get('page', 1);
        $limit = self::ITEMS_PER_PAGE_ADMIN;
        $offset = ($page-1)*$limit;

        $countItems = $articleRepository->countItems();

        return
            [
                'entities' => $articleRepository->findList($limit, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / $limit)
            ];
    }

    /**
     * @Route("/admin/article/add", name="new_article")
     * @Template("admin/article/add.html.twig")
     */
    public function addArticle(Request $request, FileUploader $fileUploader)
    {
        $article = new Article;
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $file = $article->getPicture();
            $fileName = $fileUploader->upload($file);
            $article->setPicture($fileName);

            $article->setPublishDate(new \DateTime(date('Y-m-d')));

            $this->saveEntity($article);

            $this->addSuccessFlash(sprintf('Successfully saved new article "%s"', $article->getName()));
            return $this->redirectToRoute('admin_list_articles');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route("/admin/article/edit/{id}", name="edit_article", requirements={"id"="\d+"})
     * @Template("/admin/article/edit.html.twig")
     */
    public function editArticle(Request $request, Article $article, FileUploader $fileUploader)
    {
        $initialPicture = $article->getPicture();
        if ($initialPicture) {
            $article->setPicture(
                new File($this->getParameter('pictures_directory') . '/' . $article->getPicture())
            );
        }
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $file = $form->get('picture')->getData();
            if ($file) {
                $fileName = $fileUploader->upload($file);
                if ($fileName) {
                    $article->setPicture($fileName);
                }
            } else {
                $article->setPicture($initialPicture);
                dump($article->getPicture());
            }

            $this->saveEntity($article);

            $this->addSuccessFlash(sprintf('Successfully edited article "%s"', $article->getName()));
            return $this->redirectToRoute('admin_list_articles');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/admin/article/delete/{id}", name="delete_article", requirements={"id"="\d+"})
     */
    public function deleteArticle(Article $article)
    {
        $this->removeEntity($article);
        $this->addSuccessFlash('Successfully deleted article');

        return $this->redirectToRoute('admin_list_articles');
    }
}
