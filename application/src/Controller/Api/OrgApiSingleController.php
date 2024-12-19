<?php
namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Jobmap\Organization;
use App\Entity\Jobmap\OrganizationLocation;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use ApiPlatform\Core\Validator\Exception\ValidationException;

use ApiPlatform\Core\Api\IriConverterInterface;

final class OrgApiSingleController
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
            $organization = $this->em->getRepository(Organization::class)->findOneBy(['id' => $id]);
            if(!$organization){
                return new JsonResponse(['status' => 'error', 'msg' => 'The organization was not found.'], 404);
            }
        } else {
            return new JsonResponse(['status' => 'error', 'msg' => 'The organization was not found.'], 404);
        }

        $dataInner = array();
        $orgLocations = $this->em->getRepository(OrganizationLocation::class)->findBy(['organization' => $organization]);

        $orgLocArray = [];
        if(count($orgLocations) > 0){
            foreach($orgLocations as $orgLocation){
                $openBusinessHours = $orgLocation->getBusinessOpenHours();
                $closeBusinessHours = $orgLocation->getBusinessCloseHours();
                
                if($openBusinessHours){
                    $openBusinessHours = $openBusinessHours->format("H:i:s");
                }
                if($closeBusinessHours){
                    $closeBusinessHours = $closeBusinessHours->format("H:i:s");
                }

                array_push($orgLocArray, array(
                    "id" => $orgLocation->getId(),
                    "businessOpenHours" => $openBusinessHours,
                    "businessCloseHours" => $closeBusinessHours,
                    "email" => $orgLocation->getEmail(),
                    "website" => $orgLocation->getWebsite(),
                    "isPrimary" => $orgLocation->getIsPrimary(),
                    "streetAddress1" => $orgLocation->getStreetAddress1(),
                    "streetAddress2" => $orgLocation->getStreetAddress2(),
                    "city" => $orgLocation->getCity(),
                    "state" => $orgLocation->getState(),
                    "country" => $orgLocation->getCountry(),
                    "zipcode" => $orgLocation->getZipcode(),
                    "website" => $orgLocation->getWebsite(),
                    "phoneNumber" => $orgLocation->getPhoneNumber(),
                    "faxNumber" => $orgLocation->getFaxNumber(),
                    "latitudeAndLongitude" => $orgLocation->getLatitudeAndLongitude()
                ));
            }
        }

        $dataInner = array(
            "id" => $organization->getId(),
            "name" => $organization->getName(),
            "naicsMajor" => $organization->getNaicsMajor(),
            "totalJobs" => $organization->getTotalEmployees(),
            "fte" => $organization->getFullTimeHoursPerWeek(),
            "locations" => $orgLocArray,
            "websiteURL" => $organization->getWebsiteURL()
        );
        return new JsonResponse($dataInner, Response::HTTP_OK);
    }
}