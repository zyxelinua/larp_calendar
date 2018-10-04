<?php
namespace App\Controller;

use App\Form\EventFormType;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Event;
use App\Entity\EventCategory;
use App\Entity\EventType;

class EventController extends BaseController
{
    const ITEMS_PER_PAGE = 5;

    /**
     * @Route("/event/list", name="list_events")
     * @Template("event/event_list.html.twig")
     */
    public function listEvent(Request $request, EventRepository $eventRepository)
    {
        $page = $request->query->get('page', 1);
        $offset = ($page-1)*self::ITEMS_PER_PAGE;

        $countItems = $eventRepository->countItems();

        return
            [
                'events' => $eventRepository->findList(self::ITEMS_PER_PAGE, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / self::ITEMS_PER_PAGE)
            ];
    }

    /**
     * @Route("event/add", name="new_event")
     * @Template("event/event_add.html.twig")
     */
    public function addEvent(Request $request)
    {
        $event = new Event;
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            $this->saveEntity($event);

            $this->addNoticeFlash('Event created and is pending approval by administrator"');
            return $this->redirectToRoute('home');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route("/event/{id}", name="show_event", requirements={"id"="\d+"})
     * @Route("/event/{slug}", name="show_event_by_slug")
     * @Template("event/event_show.html.twig")
     */
    public function showEvent(Event $event)
    {
        return ['event'=>$event];
    }
}
