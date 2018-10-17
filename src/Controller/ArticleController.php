<?php
namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\AdminEntityType;

class ArticleController extends BaseController
{
    const ITEMS_PER_PAGE = 10;

    /**
     * @Route("/admin/article/list", name="list_articles")
     * @Template("admin/article/list.html.twig")
     */
    public function listArticle(Request $request, ArticleRepository $articleRepository)
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
    public function addCategory(Request $request)
    {
        $article = new Article;
        $form = $this->createForm(AdminEntityType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $this->saveEntity($article);

            $this->addSuccessFlash(sprintf('Successfully saved new article "%s"', $article->getName()));
            return $this->redirectToRoute('list_articles');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route(
     * "/admin/article/article_edit",
     * name="edit_article",
     * methods={"POST"},
     * requirements={
     *  "_format": "json"
     *  }
     * )
     */
    public function editArticleTitle(Request $request, ArticleRepository $articleRepository)
    {
        $content = json_decode($request->getContent(), true);
        if (isset($content['id']) && isset($content['name'])) {
            $id = $content['id'];
            $newName = $content['name'];
            $article = $articleRepository->find($id);
            if ($article) {
                $article->setName($newName);
                $this->saveEntity($article);

                return new Response($article->getName());
            } else {
                throw $this->createNotFoundException('Article doesn\'t exist');
            }
        } else {
            throw new BadRequestHttpException('Not valid request', null, 400);
        }
    }

    /**
     * @Route("/admin/article/article_delete/{id}", name="delete_article")
     */
    public function deleteArticle(Article $article)
    {
        if (count($article->getEvents()) > 0) {
            $this->addNoticeFlash('This article has associated events and can not be deleted');
        } else {
            $this->removeEntity($article);
            $this->addSuccessFlash('Successfully deleted article');
        }
        return $this->redirectToRoute('list_articles');
    }
}
