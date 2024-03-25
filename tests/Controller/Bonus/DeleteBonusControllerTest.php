<?php

declare(strict_types=1);

namespace App\Tests\Controller\Bonus;

use App\Entity\Bonus\BonusFactory;
use App\Repository\Bonus\BonusRepository;
use App\Tests\Controller\Traits\ProcessResponseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteBonusControllerTest extends WebTestCase
{
    use ProcessResponseTrait;

    public function testSuccessDelete(): void
    {
        $client = static::createClient();
        $bonusId = static::getContainer()
            ->get(BonusRepository::class)
            ->findOneByName(BonusFactory::TEST_BONUS_FOR_DELETE_NAME)
            ?->getId();

        $client->request(
            'DELETE',
            '/api/bonus/'.$bonusId,
        );

        $content = $this->processSuccessResponse($client->getResponse()->getContent());

        $this->assertSame("Bonus $bonusId was deleted successfully", $content);
    }

    public function testInvalidDelete(): void
    {
        $client = static::createClient();
        $clientId = 9999999;
        $client->request(
            'DELETE',
            '/api/bonus/'.$clientId,
        );

        $content = $this->processErrorResponse($client->getResponse()->getContent());

        $this->assertSame("Bonus $clientId not found", $content);
    }
}
