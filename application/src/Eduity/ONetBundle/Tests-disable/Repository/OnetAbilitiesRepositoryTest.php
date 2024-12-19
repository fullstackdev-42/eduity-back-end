<?php
namespace App\Eduity\ONetBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Eduity\ONetBundle\Entity\OnetAbilities;

class OnetAbilitiesRepositoryTest extends KernelTestCase {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $abilitiesRepo;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setup();
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->abilitiesRepo = $this->entityManager->getRepository(OnetAbilities::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->abilitiesRepo = null;

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    /**** TESTS ****/

    /* If the data is "correct" then counting rows should remain the same */
    public function testCountAbilities() {
        $query = $this->abilitiesRepo->buildQueryByScale('IM', 3);
        $query->select('count(a.id)');

        $abilitiesCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(18020, $abilitiesCount);
    }

    public function testCountAbilitiesByImportance() {
        $query = $this->abilitiesRepo->buildQueryByScale('IM');
        $query->select('count(a.id)');

        $abilitiesCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(50232, $abilitiesCount);
    }

    public function testCountAbilitiesByLevel() {
        $query = $this->abilitiesRepo->buildQueryByScale('LV');
        $query->select('count(a.id)');

        $abilitiesCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(50079, $abilitiesCount);
    }

}