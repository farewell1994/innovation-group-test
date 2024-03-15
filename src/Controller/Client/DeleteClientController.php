<?php

namespace App\Controller\Client;

use App\Entity\Client\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteClientController extends AbstractController
{
    #[Route('/client/delete/{client}', 'app_client_delete')]
    public function create(Client $client, EntityManagerInterface $em): Response
    {
        try {
            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Client was successfully deleted');
        } catch (\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirect($this->generateUrl('app_client_list'));
    }
}
