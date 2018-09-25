<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Event;
use App\Repository\EventRepository;

class HomeController extends BaseController
{
    const ITEMS_ON_HOMEPAGE = 6;
    /**
     * @Route("/home", name="home")
     * @Template("home.html.twig")
     *
     */
    public function home(EventRepository $eventRepository)
    {
        return ['new_events' => $eventRepository->findLatest(self::ITEMS_ON_HOMEPAGE)];
    }
}
