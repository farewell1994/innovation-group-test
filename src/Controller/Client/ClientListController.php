<?php

namespace App\Controller\Client;

use App\Repository\Client\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientListController extends AbstractController
{
    #[Route('/clients', 'app_client_list')]
    public function list(Request $request, ClientRepository $clients): Response
    {
        return $this->render('client/list.html.twig', [
            'clients' => $clients->findAll()
        ]);
    }
}
