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

final class OrgApiAllController
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

    public function __invoke(Request $request)
    {
    	$organizations = $this->em->getRepository(Organization::class)->findAll();
        if(count($organizations) == 0){
            $data = [
                "organizations" => array()
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }

        $dataInner = array();
        foreach($organizations as $organization){
            $orgLocations = $this->em->getRepository(Organization::class)->findBy(['organization' => $organization]);

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

            array_push($dataInner, array(
                "id" => $organization->getId(),
                "name" => $organization->getName(),
                "naicsMajor" => $organization->setNaicsMajor(),
                "totalJobs" => $organization->getTotalEmployees(),
                "fte" => $organization->getFullTimeHoursPerWeek(),
                "locations" => $orgLocArray,
                "websiteURL" => $organization->getWebsiteURL()
            ));
        }
        $data = [
            "organizations" => $dataInner
        ];
        return new JsonResponse($dataInner, Response::HTTP_OK);
    }
}