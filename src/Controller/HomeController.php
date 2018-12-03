<?php
namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Event;
use App\Repository\EventRepository;

class HomeController extends BaseController
{
    const ITEMS_ON_HOMEPAGE = 12;

    /**
     * @Route("/", name="home")
     * @Template("home.html.twig")
     *
     */
    public function home(NewsRepository $newsRepository)
    {
        return ['posts' => $newsRepository->findLatest(self::ITEMS_ON_HOMEPAGE)];
    }

    /**
     * @Route("/about_mixDesk", name="mixDesk_guide")
     * @Template("mixDesk.html.twig")
     *
     */
    public function mixDeskGuide()
    {
        return [];
    }

    /**
     * @Route("/about_genres", name="genres_guide")
     * @Template("genres_guide.html.twig")
     *
     */
    public function genresGuide()
    {
        return [];
    }

    /**
     * @Route("/contacts", name="contacts")
     * @Template("contacts.html.twig")
     *
     */
    public function contacts()
    {
        return [];
    }
}
