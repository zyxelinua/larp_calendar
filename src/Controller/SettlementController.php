<?php
namespace App\Controller;

use App\Entity\Settlement;
use App\Repository\SettlementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\AdminEntityType;

class SettlementController extends BaseController
{
    const ITEMS_PER_PAGE = 10;

    /**
     * @Route("/admin/settlement/list", name="list_settlements")
     * @Template("admin/settlement/list.html.twig")
     */
    public function listSettlement(Request $request, SettlementRepository $settlementRepository)
    {
        $page = $request->get('page', 1);
        $limit = self::ITEMS_PER_PAGE;
        $offset = ($page-1)*$limit;

        $countItems = $settlementRepository->countItems();

        return
            [
                'entities' => $settlementRepository->findList($limit, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / $limit),
                'deletePath' => 'delete_settlement',
                'editPath' => 'edit_settlement'
            ];
    }

    /**
     * @Route("/admin/settlement/add", name="new_settlement")
     * @Template("admin/settlement/add.html.twig")
     */
    public function addSettlement(Request $request)
    {
        $settlement = new Settlement;
        $form = $this->createForm(AdminEntityType::class, $settlement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $settlement = $form->getData();

            $this->saveEntity($settlement);

            $this->addSuccessFlash(sprintf('Successfully saved new settlement "%s"', $settlement->getName()));
            return $this->redirectToRoute('list_settlements');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route(
     * "/admin/settlement/settlement_edit",
     * name="edit_settlement",
     * methods={"POST"},
     * requirements={
     *  "_format": "json"
     *  }
     * )
     */
    public function editSettlementTitle(Request $request, SettlementRepository $settlementRepository)
    {
        $content = json_decode($request->getContent(), true);
        if (isset($content['id']) && isset($content['name'])) {
            $id = $content['id'];
            $newName = $content['name'];
            $settlement = $settlementRepository->find($id);
            if ($settlement) {
                $settlement->setName($newName);
                $this->saveEntity($settlement);

                return new Response($settlement->getName());
            } else {
                throw $this->createNotFoundException('Settlement doesn\'t exist');
            }
        } else {
            throw new BadRequestHttpException('Not valid request', null, 400);
        }
    }

    /**
     * @Route("/admin/settlement/settlement_delete/{id}", name="delete_settlement")
     */
    public function deleteSettlement(Settlement $settlement)
    {
        if (count($settlement->getEvents()) > 0) {
            $this->addNoticeFlash('This settlement has associated events and can not be deleted');
        } else {
            $this->removeEntity($settlement);
            $this->addSuccessFlash('Successfully deleted settlement');
        }
        return $this->redirectToRoute('list_settlements');
    }
}
