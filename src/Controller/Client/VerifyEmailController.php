<?php

namespace App\Controller\Client;

use App\Entity\Client\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VerifyEmailController extends AbstractController
{
    #[Route('/client/verify-email/{client}', 'app_client_verify_email')]
    public function verifyEmail(Client $client, EntityManagerInterface $em): Response
    {
        try {
            $client->setIsEmailVerified(true);
            $em->flush();
            $this->addFlash('success', 'Email was successfully verified');
        } catch (\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirect($this->generateUrl('app_client_list'));
    }
}
