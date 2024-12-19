<?php
namespace App\Eduity\ONetBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Eduity\ONetBundle\Entity\OnetWorkContext;

class OnetWorkContextRepositoryTest extends KernelTestCase {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $workContextRepo;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->workContextRepo = $this->entityManager->getRepository(OnetWorkContext::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->workContextRepo = null;

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    /**** TESTS ****/

    /* If the data is "correct" then counting rows should remain the same */
    public function testCountWorkcontexts() {
        $query = $this->workContextRepo->buildQueryByScale('CX');
        $query->select('count(w.id)');

        $workcontextsCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(40910, $workcontextsCount);
    }

    public function testCountWorkcontextsByScale() {
        $query = $this->workContextRepo->buildQueryByScale('CX', 3);
        $query->select('count(w.id)');

        $workcontextsCount = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals(19245, $workcontextsCount);
    }
    
}