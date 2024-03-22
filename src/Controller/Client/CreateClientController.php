<?php

namespace App\Controller\Client;

use App\Controller\Traits\FormErrorsResponseTrait;
use App\Entity\Client\Client;
use App\Entity\Client\ClientFactory;
use App\Form\Type\Client\ClientFormType;
use App\Manager\BaseManager;
use App\Model\DTO\FormErrorResponseDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateClientController extends AbstractController
{
    use FormErrorsResponseTrait;

    #[Route('/api/client', methods: ['POST'])]
    #[OA\RequestBody(
        content: [
            new MediaType(
                mediaType: 'multipart/form-data',
                schema: new Schema(ref: new Model(type: ClientFormType::class))
            ),
        ]
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Successfully action',
        content: new OA\JsonContent(ref: new Model(type: Client::class, groups: ['api_response']))
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Bad request',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: FormErrorResponseDTO::class))
        )
    )]
    #[OA\Tag(name: 'Clients')]
    public function __invoke(Request $request, BaseManager $manager): Response
    {
        $client = ClientFactory::create();
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $manager->save($client);

            $data = $client;
            $status = Response::HTTP_OK;
        } else {
            $data = $this->getFormattedFormErrors($form);
            $status = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($data, $status);
    }
}
