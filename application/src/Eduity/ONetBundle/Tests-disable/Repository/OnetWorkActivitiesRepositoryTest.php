<?php
namespace App\Eduity\ONetBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Eduity\ONetBundle\Entity\OnetWorkActivities;

class OnetWorkActivitiesRepositoryTest extends KernelTestCase {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $activitiesRepo;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->activitiesRepo = $this->entityManager->getRepository(OnetWorkActivities::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->activitiesRepo = null;

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    /**** TESTS ****/

    /* If the data is "correct" then counting rows should remain the same */
    public function testCountActivities() {
        $query = $this->activitiesRepo->buildQueryByScale('IM', 3);
        $query->select('count(a.id)');

        $activitiesCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(16909, $activitiesCount);
    }

    public function testCountActivitiesByImportance() {
        $query = $this->activitiesRepo->buildQueryByScale('IM');
        $query->select('count(a.id)');

        $activitiesCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(30503, $activitiesCount);
    }

    public function testCountActivitiesByLevel() {
        $query = $this->activitiesRepo->buildQueryByScale('LV');
        $query->select('count(a.id)');

        $activitiesCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(29385, $activitiesCount);
    }

}