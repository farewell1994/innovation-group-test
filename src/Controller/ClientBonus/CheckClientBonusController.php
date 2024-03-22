<?php

declare(strict_types=1);

namespace App\Controller\ClientBonus;

use App\Controller\Traits\ResponseTrait;
use App\Entity\ClientBonus\ClientBonus;
use App\Repository\Client\ClientRepository;
use App\Services\ClientBonus\ClientBonusBuilder;
use App\Services\ClientBonus\ClientBonusDirector;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CheckClientBonusController extends AbstractController
{
    use ResponseTrait;

    #[Route('/api/client-bonus/{clientId}', requirements: ['clientId' => '\d+'], methods: ['POST'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'List of applied client bonuses',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ClientBonus::class, groups: ['api_response']))
        )
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Bad request',
        content: new OA\JsonContent(
            type: 'string'
        )
    )]
    #[OA\Tag(name: 'Client bonuses')]
    public function __invoke(
        int $clientId,
        ClientBonusBuilder $clientBonusBuilder,
        ClientRepository $clients
    ): JsonResponse {
        if ($client = $clients->getClientsWithBonusesQuery($clientId)) {
            $data = (new ClientBonusDirector())->build($clientBonusBuilder, $client);

            return $this->successResponse($data);
        }

        return $this->errorResponse("Client $clientId not found");
    }
}
