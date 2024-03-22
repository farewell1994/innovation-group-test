<?php

declare(strict_types=1);

namespace App\Services\Paginator;

use App\Entity\Bonus\Bonus;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

class BonusPaginator extends Paginator
{
    #[OA\Property(
        type: 'array',
        items: new OA\Items(ref: new Model(type: Bonus::class, groups: ['api_response']))
    )]
    #[Groups(['api_response'])]
    private array $items;
}
