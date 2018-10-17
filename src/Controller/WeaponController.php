<?php
namespace App\Controller;

use App\Entity\Weapon;
use App\Repository\WeaponRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\AdminEntityType;

class WeaponController extends BaseController
{
    const ITEMS_PER_PAGE = 10;

    /**
     * @Route("/admin/weapon/list", name="list_weapons")
     * @Template("admin/weapon/list.html.twig")
     */
    public function listWeapon(Request $request, WeaponRepository $weaponRepository)
    {
        $page = $request->get('page', 1);
        $limit = self::ITEMS_PER_PAGE;
        $offset = ($page-1)*$limit;

        $countItems = $weaponRepository->countItems();

        return
            [
                'entities' => $weaponRepository->findList($limit, $offset),
                'page' => $page,
                'pageCount' => ceil($countItems / $limit),
                'deletePath' => 'delete_weapon',
                'editPath' => 'edit_weapon'
            ];
    }

    /**
     * @Route("/admin/weapon/add", name="new_weapon")
     * @Template("admin/weapon/add.html.twig")
     */
    public function addWeapon(Request $request)
    {
        $weapon = new Weapon;
        $form = $this->createForm(AdminEntityType::class, $weapon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $weapon = $form->getData();

            $this->saveEntity($weapon);

            $this->addSuccessFlash(sprintf('Successfully saved new weapon "%s"', $weapon->getName()));
            return $this->redirectToRoute('list_weapons');
        }

        return ['form' => $form->createView()] ;
    }

    /**
     * @Route(
     * "/admin/weapon/weapon_edit",
     * name="edit_weapon",
     * methods={"POST"},
     * requirements={
     *  "_format": "json"
     *  }
     * )
     */
    public function editWeaponTitle(Request $request, WeaponRepository $weaponRepository)
    {
        $content = json_decode($request->getContent(), true);
        if (isset($content['id']) && isset($content['name'])) {
            $id = $content['id'];
            $newName = $content['name'];
            $weapon = $weaponRepository->find($id);
            if ($weapon) {
                $weapon->setName($newName);
                $this->saveEntity($weapon);

                return new Response($weapon->getName());
            } else {
                throw $this->createNotFoundException('Weapon doesn\'t exist');
            }
        } else {
            throw new BadRequestHttpException('Not valid request', null, 400);
        }
    }

    /**
     * @Route("/admin/weapon/weapon_delete/{id}", name="delete_weapon")
     */
    public function deleteWeapon(Weapon $weapon)
    {
        if (count($weapon->getEvents()) > 0) {
            $this->addNoticeFlash('This weapon has associated events and can not be deleted');
        } else {
            $this->removeEntity($weapon);
            $this->addSuccessFlash('Successfully deleted weapon');
        }
        return $this->redirectToRoute('list_weapons');
    }
}
