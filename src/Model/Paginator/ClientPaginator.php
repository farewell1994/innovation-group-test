<?php

namespace App\Model\Paginator;

use App\Entity\Client\Client;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Attribute\Groups;
use OpenApi\Attributes as OA;

class ClientPaginator extends Paginator
{
    #[OA\Property(
        type: 'array',
        items: new OA\Items(ref: new Model(type: Client::class, groups: ['api_response']))
    )]
    #[Groups(["api_response"])]
    protected array $items;
}
