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
}
