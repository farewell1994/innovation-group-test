<?php

namespace App\Tests\Controller\Bonus;

use App\Entity\Bonus\BonusFactory;
use App\Repository\Bonus\BonusRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteBonusControllerTest extends WebTestCase
{
    public function testSuccessDelete(): void
    {
        $client = static::createClient();
        $bonusId = $this->getBonusIdToDelete();

        $client->request(
            'DELETE',
            '/api/bonus/' . $bonusId,
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame("Bonus $bonusId was deleted successfully", $content);
    }

    public function testInvalidDelete(): void
    {
        $client = static::createClient();
        $clientId = 9999999;
        $client->request(
            'DELETE',
            '/api/bonus/' . $clientId,
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame("Bonus $clientId not found", $content);
    }

    private function getBonusIdToDelete(): int
    {
        /** @var BonusRepository $bonuses */
        $bonuses = static::getContainer()
            ->get(BonusRepository::class);

        $qb = $bonuses->createQueryBuilder('b');

        return $qb
            ->select('b.id')
            ->where($qb->expr()->eq('b.name',  ':nameToDelete'))
            ->setMaxResults(1)
            ->setParameter('nameToDelete', BonusFactory::TEST_BONUS_FOR_DELETE_NAME)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
