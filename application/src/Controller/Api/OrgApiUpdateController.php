<?php
namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Jobmap\Organization;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use ApiPlatform\Core\Validator\Exception\ValidationException;

use ApiPlatform\Core\Api\IriConverterInterface;

final class OrgApiUpdateController
{
	private $em;
    private $decorated;	
	private $validator;
    public function __construct(IriConverterInterface $decorated, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->decorated = $decorated;
    }

    public function getItemFromIri(string $iri, array $context = [])
    {
        return $this->decorated->getItemFromIri($iri, $context);
    }

    public function __invoke(Request $request, $id)
    {
        if(isset($id) && $id > 0){
            $newOrganization = $this->em->getRepository(Organization::class)->findOneBy(['id' => $id]);
            if(!$newOrganization){
                return new JsonResponse(['status' => 'error', 'msg' => 'The organization was not found.'], 404);
            }
        } else {
            return new JsonResponse(['status' => 'error', 'msg' => 'The organization was not found.'], 404);
        }

    	$name = $request->get('name');
        $entityType = $request->get('entityType');
        $missionStatement = $request->get('missionStatement');
        $valueProposition = $request->get('valueProposition');
        $websiteURL = $request->get('websiteURL');
        $mainPhone = $request->get('mainPhone');
      	$mainEmail = $request->get('mainEmail');
        $naicsMajor = $request->get('naicsMajor');
        $naicsMinor = $request->get('naicsMinor');
        $administrator = $request->get('administrator');
        $totalEmployees = $request->get('totalEmployees');
        $annualRevenue = $request->get('annualRevenue');
        $financialYearEnds = $request->get('financialYearEnds');
        $fullTimeHoursPerWeek = $request->get('fullTimeHoursPerWeek');
        $businessHours = $request->get('businessHours');
        $dateFounded = $request->get('dateFounded');
        
        $newuser = null;
        if($administrator)
            $newuser = $this->getItemFromIri($administrator);

        $newOrganization
        ->setName($name)
        ->setEntityType($entityType)
        ->setMissionStatement($missionStatement)
        ->setValueProposition($valueProposition)
        ->setWebsiteURL($websiteURL)
        ->setMainPhone($mainPhone)
        ->setMainEmail($mainEmail)
        ->setNaicsMajor($naicsMajor)
        ->setNaicsMinor($naicsMinor)
        ->setTotalEmployees($totalEmployees)
        ->setAnnualRevenue($annualRevenue)
        ->setFinancialYearEnds($financialYearEnds)
        ->setFullTimeHoursPerWeek($fullTimeHoursPerWeek)
        ->setBusinessHours($businessHours)
        ->setDateFounded(new \DateTime($dateFounded))
        ->setOwner($newuser);

        $violations = $this->validator->validate($newOrganization);
        if (0 !== count($violations)) {
            throw new ValidationException($violations);
        }

        $this->em->persist($newOrganization);
        $this->em->flush();

        $organizationId = $newOrganization->getId();

        if($organizationId > 0){
            $organization = $newOrganization;
            $data = [
                "id" => $organizationId,
                "name" => $organization->getName(),
                "entityType" => $organization->getEntityType(),
                "missionStatement" => $organization->getMissionStatement(),
                "valueProposition" => $organization->getValueProposition(),
                "websiteURL" => $organization->getWebsiteURL(),
                "mainPhone" => $organization->getMainPhone(),
                "mainEmail" => $organization->getMainEmail(),
                "naicsMajor" => $organization->getNaicsMajor(), //string
                "naicsMinor" => $organization->getNaicsMinor(), //string
                "administrator" => $organization->getAdministratorId(),
                "totalEmployees" => $organization->getTotalEmployees(),
                "annualRevenue" => $organization->getAnnualRevenue(), // does this require units?
                "financialYearEnds" => $organization->getFinancialYearEnds(),
                "fullTimeHoursPerWeek" => $organization->getFullTimeHoursPerWeek(),
                "businessHours" => $organization->getBusinessHours()
            ];
            return new JsonResponse($data, Response::HTTP_OK);
            // return new JsonResponse(['status' => 'success', 'msg' => 'The organization has been updated successfully.'], 200);
        } else {
            return new JsonResponse(['status' => 'error', 'msg' => 'There was a problem with your submission.'], 500);
        }
    }
}