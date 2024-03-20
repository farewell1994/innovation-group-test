<?php

namespace App\Controller\Client;

use App\Controller\Traits\FormErrorsResponseTrait;
use App\Entity\Client\Client;
use App\Form\Type\Client\ClientFormType;
use App\Manager\BaseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class CreateClientController extends AbstractController
{
    use FormErrorsResponseTrait;

    #[Route('/api/client', methods: ['POST'])]
    #[OA\Tag(name: 'Clients')]
    public function __invoke(Request $request, BaseManager $manager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid() && $manager->save($client)) {
            return $this->json('Client was created successfully');
        } else {
            return $this->json($this->getFormattedFormErrors($form), Response::HTTP_BAD_REQUEST);
        }
    }
}
