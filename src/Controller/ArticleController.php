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

class ArticleController extends BaseController
{
    const ITEMS_PER_PAGE = 5;

    /**
     * @Route("/article/list", name="list_articles")
     * @Template("article/article_list.html.twig")
     */
    public function listArticle(Request $request, ArticleRepository $articleRepository)
    {
        $page = $request->query->get('page', 1);
        $offset = ($page-1)*self::ITEMS_PER_PAGE;

        $countItems = $articleRepository->countItemsByCategory(Article::CATEGORY_ARTICLE);

        return
            [
                'articles' => $articleRepository->findListByCategory(self::ITEMS_PER_PAGE, $offset, Article::CATEGORY_ARTICLE),
                'page' => $page,
                'pageCount' => ceil($countItems / self::ITEMS_PER_PAGE)
            ];
    }

    /**
     * @Route("/article/overview/list", name="list_overviews")
     * @Template("article/overview_list.html.twig")
     */
    public function listOverview(Request $request, ArticleRepository $articleRepository)
    {
        $page = $request->query->get('page', 1);
        $offset = ($page-1)*self::ITEMS_PER_PAGE;

        $countItems = $articleRepository->countItemsByCategory(Article::CATEGORY_OVERVIEW);

        return
            [
                'articles' => $articleRepository->findListByCategory(self::ITEMS_PER_PAGE, $offset, Article::CATEGORY_OVERVIEW),
                'page' => $page,
                'pageCount' => ceil($countItems / self::ITEMS_PER_PAGE)
            ];
    }

    /**
     * @Route("/article/{id}", name="show_article", requirements={"id"="\d+"})
     * @Route("/article/{slug}", name="show_article_by_slug")
     * @Template("article/article_show.html.twig")
     */
    public function showArticle(Article $article)
    {
        return ['article'=>$article];
    }

    /**
     * @Route("/admin/article/list", name="admin_list_articles")
     * @Template("admin/article/list.html.twig")
     */
    public function listArticlesAdmin(Request $request, ArticleRepository $articleRepository)
    {
        $page = $request->get('page', 1);
        $limit = self::ITEMS_PER_PAGE;
        $offset = ($page-1)*$limit;

        $countItems = $articleRepository->countItems();

        return
            [
                'entities' => $articleRepository->findList($limit, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / $limit),
                'deletePath' => 'delete_article',
                'editPath' => 'edit_article'
            ];
    }

    /**
     * @Route("/admin/article/add", name="new_article")
     * @Template("admin/article/add.html.twig")
     */
    public function addArticle(Request $request)
    {
        $article = new Article;
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

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
    public function editArticle(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

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
