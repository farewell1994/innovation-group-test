<?php

namespace App\Controller\Bonus;

use App\Entity\Bonus\Bonus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteBonusController extends AbstractController
{
    #[Route('/bonus/delete/{bonus}', 'app_bonus_delete')]
    public function create(Bonus $bonus, EntityManagerInterface $em): Response
    {
        try {
            $em->remove($bonus);
            $em->flush();
            $this->addFlash('success', 'Bonus was successfully deleted');
        } catch (\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirect($this->generateUrl('app_bonus_list'));
    }
}
