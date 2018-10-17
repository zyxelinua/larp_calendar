<?php
namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\AdminEntityType;

class AuthorController extends BaseController
{
    const ITEMS_PER_PAGE = 10;

    /**
     * @Route("/admin/author/list", name="list_authors")
     * @Template("admin/author/list.html.twig")
     */
    public function listAuthor(Request $request, AuthorRepository $authorRepository)
    {
        $page = $request->get('page', 1);
        $limit = self::ITEMS_PER_PAGE;
        $offset = ($page-1)*$limit;

        $countItems = $authorRepository->countItems();

        return
            [
                'entities' => $authorRepository->findList($limit, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / $limit),
                'deletePath' => 'delete_author',
                'editPath' => 'edit_author'
            ];
    }

    /**
     * @Route("/admin/author/add", name="new_author")
     * @Template("admin/author/add.html.twig")
     */
    public function addAuthor(Request $request)
    {
        $author = new author;
        $form = $this->createForm(AdminEntityType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $this->saveEntity($author);

            $this->addSuccessFlash(sprintf('Successfully saved new author "%s"', $author->getName()));
            return $this->redirectToRoute('list_authors');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route(
     * "/admin/author/author_edit",
     * name="edit_author",
     * methods={"POST"},
     * requirements={
     *  "_format": "json"
     *  }
     * )
     */
    public function editAuthorTitle(Request $request, AuthorRepository $authorRepository)
    {
        $content = json_decode($request->getContent(), true);
        if (isset($content['id']) && isset($content['name'])) {
            $id = $content['id'];
            $newName = $content['name'];
            $author = $authorRepository->find($id);
            if ($author) {
                $author->setName($newName);
                $this->saveEntity($author);

                return new Response($author->getName());
            } else {
                throw $this->createNotFoundException('author doesn\'t exist');
            }
        } else {
            throw new BadRequestHttpException('Not valid request', null, 400);
        }
    }

    /**
     * @Route("/admin/author/author_delete/{id}", name="delete_author")
     */
    public function deleteAuthor(Author $author)
    {
        if (count($author->getArticles()) > 0) {
            $this->addNoticeFlash('This author has associated articles and can not be deleted');
        } else {
            $this->removeEntity($author);
            $this->addSuccessFlash('Successfully deleted author');
        }
        return $this->redirectToRoute('list_authors');
    }
}
