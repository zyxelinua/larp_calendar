<?php
namespace App\Controller;

use App\Entity\EventType;
use App\Repository\EventTypeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\AdminEntityType;

class EventTypeController extends BaseController
{
    const ITEMS_PER_PAGE = 10;

    /**
     * @Route("/admin/eventType/list", name="list_eventTypes")
     * @Template("admin/eventType/list.html.twig")
     */
    public function listEventType(Request $request, EventTypeRepository $eventTypeRepository)
    {
        $page = $request->get('page', 1);
        $limit = self::ITEMS_PER_PAGE;
        $offset = ($page-1)*$limit;

        $countItems = $eventTypeRepository->countItems();

        return
            [
                'entities' => $eventTypeRepository->findList($limit, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / $limit),
                'deletePath' => 'delete_eventType',
                'editPath' => 'edit_eventType'
            ];
    }

    /**
     * @Route("/admin/eventType/add", name="new_eventType")
     * @Template("admin/eventType/add.html.twig")
     */
    public function addCategory(Request $request)
    {
        $eventType = new EventType;
        $form = $this->createForm(AdminEntityType::class, $eventType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventType = $form->getData();

            $this->saveEntity($eventType);

            $this->addSuccessFlash(sprintf('Successfully saved new event format "%s"', $eventType->getName()));
            return $this->redirectToRoute('list_eventTypes');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route(
     * "/admin/eventType/eventType_edit",
     * name="edit_eventType",
     * methods={"POST"},
     * requirements={
     *  "_format": "json"
     *  }
     * )
     */
    public function editEventTypeTitle(Request $request, EventTypeRepository $eventTypeRepository)
    {
        $content = json_decode($request->getContent(), true);
        if (isset($content['id']) && isset($content['name'])) {
            $id = $content['id'];
            $newName = $content['name'];
            $eventType = $eventTypeRepository->find($id);
            if ($eventType) {
                $eventType->setName($newName);
                $this->saveEntity($eventType);

                return new Response($eventType->getName());
            } else {
                throw $this->createNotFoundException('EventType doesn\'t exist');
            }
        } else {
            throw new BadRequestHttpException('Not valid request', null, 400);
        }
    }

    /**
     * @Route("/admin/eventType/eventType_delete/{id}", name="delete_eventType")
     */
    public function deleteEventType(EventType $eventType)
    {
        if (count($eventType->getEvents()) > 0) {
            $this->addNoticeFlash('This event format has associated events and can not be deleted');
        } else {
            $this->removeEntity($eventType);
            $this->addSuccessFlash('Successfully deleted event format');
        }
        return $this->redirectToRoute('list_eventTypes');
    }
}
