<?php

namespace App\Controller\Bonus;

use App\Controller\Traits\FormErrorsResponseTrait;
use App\Entity\Bonus\Bonus;
use App\Entity\Bonus\BonusFactory;
use App\Form\Type\Bonus\BonusFormType;
use App\Manager\BaseManager;
use App\Model\FormErrorResponseDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class CreateBonusController extends AbstractController
{
    use FormErrorsResponseTrait;

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
        content: new OA\JsonContent(ref: new Model(type: Bonus::class))
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
    public function __invoke(Request $request, BaseManager $manager): Response
    {
        $bonus = BonusFactory::create();
        $form = $this->createForm(BonusFormType::class, $bonus);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid() && $manager->save($bonus)) {
            return $this->json($bonus, Response::HTTP_OK);
        } else {
            return $this->json($this->getFormattedFormErrors($form), Response::HTTP_BAD_REQUEST);
        }
    }
}
