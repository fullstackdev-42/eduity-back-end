<?php
namespace App\Eduity\ONetBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Eduity\ONetBundle\Entity\OnetOccupationData;

class OnetOccupationDataRepositoryTest extends KernelTestCase {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $occupationsRepo;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->occupationsRepo = $this->entityManager->getRepository(OnetOccupationData::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->occupationsRepo = null;

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    /**** TESTS ****/

    /* If the data is "correct" then counting rows should remain the same */
    public function testCountOccupations() {
        $query = $this->occupationsRepo->buildQueryByScale('IM', 3);
        $query->select('count(o.onetsocCode)');

        $occupationsCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(18020, $occupationsCount);
    }

    public function testCountOccupationsByImportance() {
        $query = $this->occupationsRepo->buildQueryByScale('IM');
        $query->select('count(o.onetsocCode)');

        $occupationsCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(50232, $occupationsCount);
    }

    public function testCountOccupationsByLevel() {
        $query = $this->occupationsRepo->buildQueryByScale('LV');
        $query->select('count(o.onetsocCode)');

        $occupationsCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(50079, $occupationsCount);
    }

    
}