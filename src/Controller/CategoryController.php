<?php
namespace App\Controller;

use App\Repository\EventCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Entity\EventCategory;
use App\Form\EventCategoryType;

class CategoryController extends BaseController
{
    const ITEMS_PER_PAGE = 10;

    /**
     * @Route("/admin/category/list", name="list_categories")
     * @Template("admin/category/category_list.html.twig")
     */
    public function listCategory(Request $request, EventCategoryRepository $eventCategoryRepository)
    {
        $page = $request->query->get('page', 1);
        $limit = self::ITEMS_PER_PAGE;
        $offset = ($page-1)*$limit;

        $countItems = $eventCategoryRepository->countItems();

        return
            [
                'categories' => $eventCategoryRepository->findList($limit, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / $limit)
            ];
    }

    /**
     * @Route("/admin/category/add", name="new_category")
     * @Template("admin/category/category_add.html.twig")
     */
    public function addCategory(Request $request)
    {
        $category = new EventCategory;
        $form = $this->createForm(EventCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $this->saveEntity($category);

            $this->addNoticeFlash(sprintf('Successfully saved new category "%s"', $category->getName()));
            return $this->redirectToRoute('list_categories');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route(
     * "/category_edit",
     * name="edit_category",
     * methods={"POST"},
     * requirements={
     *  "_format": "json"
     *  }
     * )
     */
    public function editCategoryTitle(Request $request, EventCategoryRepository $eventCategoryRepository)
    {
        $content = json_decode($request->getContent(), true);
        if (in_array('id', $content) && in_array('name', $content)) {
            $id = $content['id'];
            $newName = $content['name'];
            $category = $eventCategoryRepository->find($id);
                if ($category) {
                    $category->setName($newName);
                    $this->saveEntity($category);

                    return new Response($category->getName());
                } else {
                    throw $this->createNotFoundException('Category doesn\'t exist');
                }
        }
        else {
            throw new BadRequestHttpException('Not valid request', null, 400);
        }
    }
}

