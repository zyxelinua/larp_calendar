<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BaseController extends Controller
{
    /**
     * @param string $message
     * @return void
     */
    public function addNoticeFlash($message)
    {
        $this->addFlash('notice', $message);
    }

    public function addSuccessFlash($message)
    {
        $this->addFlash('success', $message);
    }

    public function addDangerFlash($message)
    {
        $this->addFlash('dander', $message);
    }

    public function saveEntity($entity)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    public function removeEntity($entity)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($entity);
        $entityManager->flush();
    }

    /**
     * @param $length
     * @param string $keyspace
     * @return string
     */
    protected function generateToken($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $token = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $token []= $keyspace[random_int(0, $max)];
        }
        return implode($token);
    }
}
