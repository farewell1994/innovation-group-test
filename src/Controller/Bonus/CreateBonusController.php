<?php

declare(strict_types=1);

namespace App\Controller\Bonus;

use App\Controller\Traits\FormErrorsResponseTrait;
use App\Controller\Traits\ResponseTrait;
use App\Entity\Bonus\Bonus;
use App\Entity\Bonus\BonusFactory;
use App\Form\Type\Bonus\BonusFormType;
use App\Manager\BaseManager;
use App\Model\DTO\FormErrorResponseDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateBonusController extends AbstractController
{
    use FormErrorsResponseTrait;
    use ResponseTrait;

    #[Route('/api/bonus', methods: ['POST'])]
    #[OA\RequestBody(
        content: [
            new MediaType(
                mediaType: 'multipart/form-data',
                schema: new Schema(ref: new Model(type: BonusFormType::class))
            ),
        ]
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Successfully action',
        content: new OA\JsonContent(ref: new Model(type: Bonus::class, groups: ['api_response']))
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Bad request',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: FormErrorResponseDTO::class))
        )
    )]
    #[OA\Tag(name: 'Bonuses')]
    public function __invoke(Request $request, BaseManager $manager): JsonResponse
    {
        $bonus = BonusFactory::init();
        $form = $this->createForm(BonusFormType::class, $bonus);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $manager->save($bonus);

            return $this->successResponse($bonus);
        }

        return $this->errorResponse($this->getFormattedFormErrors($form));
    }
}
