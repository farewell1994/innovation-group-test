<?php

namespace App\Services\Paginator;

use App\Entity\ClientBonus\ClientBonus;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

class ClientBonusPaginator extends Paginator
{
    #[OA\Property(
        type: 'array',
        items: new OA\Items(ref: new Model(type: ClientBonus::class, groups: ['api_response']))
    )]
    #[Groups(["api_response"])]
    protected array $items;
}
