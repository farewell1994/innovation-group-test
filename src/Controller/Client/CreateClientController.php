<?php

namespace App\Controller\Client;

use App\Entity\Client\Client;
use App\Form\Type\Client\ClientFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateClientController extends AbstractController
{
    #[Route('/client/create', 'app_client_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $client = new Client();
        $form = $this->getClientForm($client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($client);
                $em->flush();
                $this->addFlash('success', 'Client was successfully created');
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
            }

            return $this->redirect($this->generateUrl('app_client_list'));
        }

        return $this->render('client/create.html.twig', [
            'client_form' => $form->createView()
        ]);
    }

    private function getClientForm(Client $client): FormInterface
    {
        return $this->createForm(ClientFormType::class, $client, [
            'action' => $this->generateUrl('app_client_create')
        ]);
    }
}
