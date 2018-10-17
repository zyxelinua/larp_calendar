<?php
namespace App\Controller;

use App\Entity\Subgenre;
use App\Repository\SubgenreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\AdminEntityType;

class SubgenreController extends BaseController
{
    const ITEMS_PER_PAGE = 10;

    /**
     * @Route("/admin/subgenre/list", name="list_subgenres")
     * @Template("admin/subgenre/list.html.twig")
     */
    public function listSubgenre(Request $request, SubgenreRepository $subgenreRepository)
    {
        $page = $request->get('page', 1);
        $limit = self::ITEMS_PER_PAGE;
        $offset = ($page-1)*$limit;

        $countItems = $subgenreRepository->countItems();

        return
            [
                'entities' => $subgenreRepository->findList($limit, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / $limit),
                'deletePath' => 'delete_subgenre',
                'editPath' => 'edit_subgenre'
            ];
    }

    /**
     * @Route("/admin/subgenre/add", name="new_subgenre")
     * @Template("admin/subgenre/add.html.twig")
     */
    public function addSubgenre(Request $request)
    {
        $subgenre = new Subgenre;
        $form = $this->createForm(AdminEntityType::class, $subgenre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subgenre = $form->getData();

            $this->saveEntity($subgenre);

            $this->addSuccessFlash(sprintf('Successfully saved new subgenre "%s"', $subgenre->getName()));
            return $this->redirectToRoute('list_subgenres');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route(
     * "/admin/subgenre/subgenre_edit",
     * name="edit_subgenre",
     * methods={"POST"},
     * requirements={
     *  "_format": "json"
     *  }
     * )
     */
    public function editSubgenreTitle(Request $request, SubgenreRepository $subgenreRepository)
    {
        $content = json_decode($request->getContent(), true);
        if (isset($content['id']) && isset($content['name'])) {
            $id = $content['id'];
            $newName = $content['name'];
            $subgenre = $subgenreRepository->find($id);
            if ($subgenre) {
                $subgenre->setName($newName);
                $this->saveEntity($subgenre);

                return new Response($subgenre->getName());
            } else {
                throw $this->createNotFoundException('Subgenre doesn\'t exist');
            }
        } else {
            throw new BadRequestHttpException('Not valid request', null, 400);
        }
    }

    /**
     * @Route("/admin/subgenre/subgenre_delete/{id}", name="delete_subgenre")
     */
    public function deleteSubgenre(Subgenre $subgenre)
    {
        if (count($subgenre->getEvents()) > 0) {
            $this->addNoticeFlash('This subgenre has associated events and can not be deleted');
        } else {
            $this->removeEntity($subgenre);
            $this->addSuccessFlash('Successfully deleted subgenre');
        }
        return $this->redirectToRoute('list_subgenres');
    }
}
