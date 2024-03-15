<?php

namespace App\Controller\Bonus;

use App\Entity\Bonus\Bonus;
use App\Form\Type\Bonus\BonusFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateBonusController extends AbstractController
{
    #[Route('/bonus/create', 'app_bonus_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $bonus = new Bonus();
        $form = $this->getBonusForm($bonus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($bonus);
                $em->flush();
                $this->addFlash('success', 'Bonus was successfully created');
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
            }

            return $this->redirect($this->generateUrl('app_bonus_list'));
        }

        return $this->render('bonus/create.html.twig', [
            'bonus_form' => $form->createView()
        ]);
    }

    private function getBonusForm(Bonus $bonus): FormInterface
    {
        return $this->createForm(BonusFormType::class, $bonus, [
            'action' => $this->generateUrl('app_bonus_create')
        ]);
    }
}
