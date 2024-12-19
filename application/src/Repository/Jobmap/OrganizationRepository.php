<?php

namespace App\Repository\Jobmap;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Jobmap\Organization;
use App\Entity\Jobmap\OrganizationLocation;
use App\Entity\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

// use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Organization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organization[]    findAll()
 * @method Organization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizationRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Organization::class);
        $this->entityManager = $entityManager;
        // $this->validator = $validator;
    }

    public function saveOrganization($data)
    {
        try{
            if(isset($data['id']) && $data['id'] > 0){
                $newOrganization = $this->findOneBy(['id' => $data['id']]);
                if(!$newOrganization){
                    return 0;
                }
            } else {
                $newOrganization = new Organization();
            }

            $id = isset($data['id']) ? $data['id'] : '';
            $name = isset($data['name']) ? $data['name'] : '';
            $entityType = isset($data['entityType']) ? $data['entityType'] : '';
            $missionStatement = isset($data['missionStatement']) ? $data['missionStatement'] : '';
            $valueProposition = isset($data['valueProposition']) ? $data['valueProposition'] : '';
            $websiteURL = isset($data['websiteURL']) ? $data['websiteURL'] : '';
            $mainPhone = isset($data['mainPhone']) ? $data['mainPhone'] : '';
            $mainEmail = isset($data['mainEmail']) ? $data['mainEmail'] : '';
            $naicsMajor = isset($data['naicsMajor']) ? $data['naicsMajor'] : null;
            $nacisMinor = isset($data['nacisMinor']) ? implode(",", $data['nacisMinor']) : '';
            $administrator = isset($data['administrator']) ? $data['administrator'] : 1;
            $totalEmployees = isset($data['totalEmployees']) ? $data['totalEmployees'] : null;
            $annualRevenue = isset($data['annualRevenue']) ? $data['annualRevenue'] : null;
            $financialYearEnds = isset($data['financialYearEnds']) ? $data['financialYearEnds'] : '';
            $fullTimeHoursPerWeek = isset($data['fullTimeHoursPerWeek']) ? $data['fullTimeHoursPerWeek'] : null;
            $businessHours = isset($data['businessHours']) ? $data['businessHours'] : '';
            $dateFounded = isset($data['dateFounded']) ? $data['dateFounded'] : '';

            $newuser = '';
            if($administrator > 0)
                $newuser = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $administrator]);

            $newOrganization
                ->setName($name)
                ->setEntityType($entityType)
                ->setMissionStatement($missionStatement)
                //->setValueProposition($valueProposition)
                //->setWebsiteUrl($websiteURL)
                //->setPhone($mainPhone)
                //->setEmail($mainEmail)
                ->setNaicsMajor($naicsMajor)
                ->setNaicsMinor($nacisMinor)
                ->setTotalEmployees($totalEmployees)
                ->setAnnualRevenue($annualRevenue)
                //->setFinancialYearEnds($financialYearEnds)
                ->setFullTimeHoursPerWeek($fullTimeHoursPerWeek);
                //->setBusinessHours($businessHours);

            // if($dateFounded){
            //     $newOrganization->setDateFounded(new \DateTime($dateFounded));
            // }
            
            if($newuser != ''){
                $newOrganization->setAdministrator($newuser);
            }

            // $validator = Validation::createValidator();
            // $validator = Validation::createValidatorBuilder()
            // ->enableAnnotationMapping()
            // ->getValidator();

            // $violations = $this->validator->validate($newOrganization);
            // return $violations;exit;

            $this->entityManager->persist($newOrganization);
            $this->entityManager->flush();

            $organizationId = $newOrganization->getId();
            if($organizationId > 0){
                return 1;
            } else {
                return 0;
            }
        } catch(\Exception $e){
            return 0;
            // return $e->getMessage();
        }
    }

    public function removeOrganization(Organization $organization)
    {
        $this->entityManager->remove($organization);
        $this->entityManager->flush();
    }

    // public function saveOrgLocation(){
    //     $newOrganization = $this->findOneBy(['id' => 7]);
    //     $organizationLocationData = new OrganizationLocation();
    //     $organizationLocationData
    //     ->setName("Test org location")
    //     ->setWebsite("http://test.com")
    //     ->setEmail('test@mail.com')
    //     ->setBusinessOpenHours(new \DateTime('08:00:00'))
    //     ->setBusinessCloseHours(new \DateTime('08:00:00'))
    //     ->setOrganization($newOrganization)
    //     ->setIsPrimary(true);
    //     $this->entityManager->persist($organizationLocationData);
    //     $this->entityManager->flush();
    // }

    // /**
    //  * @return Organization[] Returns an array of Organization objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Organization
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
