<?php
namespace App\Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\GenreType;

class GenreController extends BaseController
{
    const ITEMS_PER_PAGE = 10;

    /**
     * @Route("/admin/genre/list", name="list_genres")
     * @Template("admin/genre/genre_list.html.twig")
     */
    public function listGenre(Request $request, GenreRepository $genreRepository)
    {
        $page = $request->get('page', 1);
        $limit = self::ITEMS_PER_PAGE;
        $offset = ($page-1)*$limit;

        $countItems = $genreRepository->countItems();

        return
            [
                'entities' => $genreRepository->findList($limit, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / $limit),
                'deletePath' => 'delete_genre',
                'editPath' => 'edit_genre'
            ];
    }

    /**
     * @Route("/admin/genre/add", name="new_genre")
     * @Template("admin/genre/genre_add.html.twig")
     */
    public function addCategory(Request $request)
    {
        $genre = new Genre;
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genre = $form->getData();

            $this->saveEntity($genre);

            $this->addNoticeFlash(sprintf('Successfully saved new genre "%s"', $genre->getName()));
            return $this->redirectToRoute('list_genres');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route(
     * "/admin/genre/genre_edit",
     * name="edit_genre",
     * methods={"POST"},
     * requirements={
     *  "_format": "json"
     *  }
     * )
     */
    public function editGenreTitle(Request $request, GenreRepository $genreRepository)
    {
        $content = json_decode($request->getContent(), true);
        if (isset($content['id']) && isset($content['name'])) {
            $id = $content['id'];
            $newName = $content['name'];
            $genre = $genreRepository->find($id);
            if ($genre) {
                $genre->setName($newName);
                $this->saveEntity($genre);

                return new Response($genre->getName());
            } else {
                throw $this->createNotFoundException('Genre doesn\'t exist');
            }
        } else {
            throw new BadRequestHttpException('Not valid request', null, 400);
        }
    }

    /**
     * @Route("/admin/genre/genre_delete/{id}", name="delete_genre")
     */
    public function deleteGenre(Genre $genre)
    {
        if (count($genre->getEvents()) > 0) {
            $this->addNoticeFlash('This genre has associated events and can not be deleted');
        } else {
            $this->removeEntity($genre);
            $this->addNoticeFlash('Successfully deleted genre');
        }
        return $this->redirectToRoute('list_genres');
    }
}
