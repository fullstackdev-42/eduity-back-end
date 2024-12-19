<?php
namespace App\Eduity\ONetBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Eduity\ONetBundle\Entity\OnetSkills;

class OnetSkillsRepositoryTest extends KernelTestCase {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $skillsRepo;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->skillsRepo = $this->entityManager->getRepository(OnetSkills::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->skillsRepo = null;

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    /**** TESTS ****/

    /* If the data is "correct" then counting rows should remain the same */
    public function testCountSkills() {
        $query = $this->skillsRepo->buildQueryByScale('IM', 3);
        $query->select('count(s.id)');

        $skillsCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(13659, $skillsCount);
    }

    public function testCountSkillsByImportance() {
        $query = $this->skillsRepo->buildQueryByScale('IM');
        $query->select('count(s.id)');

        $skillsCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(33810, $skillsCount);
    }

    public function testCountSkillsByLevel() {
        $query = $this->skillsRepo->buildQueryByScale('LV');
        $query->select('count(s.id)');

        $skillsCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(33389, $skillsCount);
    }
    
}