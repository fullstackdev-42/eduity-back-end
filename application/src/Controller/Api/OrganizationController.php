<?php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\Jobmap\OrganizationRepository;
use App\Repository\Jobmap\OrganizationLocationRepository;

/**
 * Route("/v1/organization")
 */
class OrganizationController extends AbstractController
{
    private $organizationRepository;

    public function __construct(OrganizationRepository $organizationRepository, OrganizationLocationRepository $organizationLocationRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->organizationLocationRepository = $organizationLocationRepository;
    }

    /**
     * Route("/create/", name="createOrganization", methods={"POST"})
     */
    public function createOrganization(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $id = 0;
        if(isset($data['id']) && $data['id'] > 0){
            $id = $data['id'];
        }

        if(!isset($data['name']) || $data['name'] == ''){
            return new JsonResponse(['status' => 'error', 'msg' => 'Organization Name is required'], 400);
        }

        if(!isset($data['administrator']) || $data['administrator'] == ''){
            return new JsonResponse(['status' => 'error', 'msg' => 'Owner Id is required'], 400);
        }
        
        if(isset($data['mainEmail']) && $data['mainEmail'] != ''){
            $regex  = '/^[A-z0-9][\w.\'-]*@[A-z0-9][\w\-\.]*\.[A-z0-9]{2,}$/';
            $result = preg_match($regex, $data['mainEmail']);
            if(!$result){
                $error_msg = "The email is not in the correct email format.";
                return new JsonResponse(['status' => 'error', 'msg' => $error_msg], 400);
            }
        }

        if(isset($data['websiteURL']) && $data['websiteURL'] != ''){
            $regex  = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i';
            $result = preg_match($regex, $data['websiteURL']);
            if(!$result){
                $error_msg = "This website URL is not in the correct website address format.";
                return new JsonResponse(['status' => 'error', 'msg' => $error_msg], 400);
            }
        }

        if(isset($data['mainPhone']) && $data['mainPhone'] != ''){
            $regex  = '/^[\(]?[\+]?[1-9]{0,1}[0-9]{0,2}[\)]?[\-\s]?[\(]?[0-9]{3,4}[\)]?[\-\s]?[0-9]{3}[\-\s]?[0-9]{4}$/';
            $result = preg_match($regex, $data['mainPhone']);
            if(!$result){
                $error_msg = "Please enter a valid phone number. Recommended format: +1-123-456-7890";
                return new JsonResponse(['status' => 'error', 'msg' => $error_msg], 400);
            }
        }

        try{
            $retStatus = $this->organizationRepository->saveOrganization($data);
            if($retStatus == 1){
                if($id > 0){
                    return new JsonResponse(['status' => 'success', 'msg' => 'The organization has been updated successfully.'], Response::HTTP_OK);
                } else {
                    return new JsonResponse(['status' => 'success', 'msg' => 'The organization has been added successfully.'], Response::HTTP_OK);
                }
            } else {
                return new JsonResponse(['status' => 'error', 'msg' => 'There was a problem with your submission.'], 500);
            }
        } catch(\Exception $e){
            return new JsonResponse(['status' => 'error', 'msg' => 'There was a problem with your submission.'], 500);
        }
    }

    /**
     * Route("/update/{id}", name="updateOrganization", methods={"POST"})
     */
    public function updateOrganization($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $data['id'] = $id;
        if(!isset($data['name']) || $data['name'] == ''){
            return new JsonResponse(['status' => 'error', 'msg' => 'Organization Name is required'], 400);
        }

        if(!isset($data['administrator']) || $data['administrator'] == ''){
            return new JsonResponse(['status' => 'error', 'msg' => 'Owner Id is required'], 400);
        }
        
        if(isset($data['mainEmail']) && $data['mainEmail'] != ''){
            $regex  = '/^[A-z0-9][\w.\'-]*@[A-z0-9][\w\-\.]*\.[A-z0-9]{2,}$/';
            $result = preg_match($regex, $data['mainEmail']);
            if(!$result){
                $error_msg = "The email is not in the correct email format.";
                return new JsonResponse(['status' => 'error', 'msg' => $error_msg], 400);
            }
        }

        if(isset($data['websiteURL']) && $data['websiteURL'] != ''){
            $regex  = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i';
            $result = preg_match($regex, $data['websiteURL']);
            if(!$result){
                $error_msg = "This website URL is not in the correct website address format.";
                return new JsonResponse(['status' => 'error', 'msg' => $error_msg], 400);
            }
        }

        if(isset($data['mainPhone']) && $data['mainPhone'] != ''){
            $regex  = '/^[\(]?[\+]?[1-9]{0,1}[0-9]{0,2}[\)]?[\-\s]?[\(]?[0-9]{3,4}[\)]?[\-\s]?[0-9]{3}[\-\s]?[0-9]{4}$/';
            $result = preg_match($regex, $data['mainPhone']);
            if(!$result){
                $error_msg = "Please enter a valid phone number. Recommended format: +1-123-456-7890";
                return new JsonResponse(['status' => 'error', 'msg' => $error_msg], 400);
            }
        }
        
        try{
            $retStatus = $this->organizationRepository->saveOrganization($data);
            if($retStatus == 1){
                if($id > 0){
                    return new JsonResponse(['status' => 'success', 'msg' => 'The organization has been updated successfully.'], Response::HTTP_OK);
                } else {
                    return new JsonResponse(['status' => 'success', 'msg' => 'The organization has been added successfully.'], Response::HTTP_OK);
                }
            } else {
                return new JsonResponse(['status' => 'error', 'msg' => 'There was a problem with your submission.'], 500);
            }
        } catch(\Exception $e){
            return new JsonResponse(['status' => 'error', 'msg' => 'There was a problem with your submission.'], 500);
        }
    }

    /**
     * Route("/get/{id}", name="getOrganizationDetails", methods={"GET"})
     */
    public function getOrganizationDetails($id): JsonResponse
    {
        $organization = $this->organizationRepository->findOneBy(['id' => $id]);
        if(!$organization){
            return new JsonResponse(array(), 500);
        }
        
        $data = [
            "id" => $id,
            "name" => $organization->getName(),
            "entityType" => $organization->getCompanyType(),
            "missionStatement" => $organization->getMissionStatement(),
            "valueProposition" => $organization->getValueProposition(),
            "websiteURL" => $organization->getWebsiteUrl(),
            "mainPhone" => $organization->getPhone(),
            "mainEmail" => $organization->getEmail(),
            "naicsMajor" => $organization->getIndustrySector(), //number
            "naicsMinor" => $organization->getIndustrySubsector(), //string
            "administrator" => $organization->getOwnerId(),
            "totalEmployees" => $organization->getTotalEmployees(),
            "annualRevenue" => $organization->getAnnualRevenue(), // does this require units?
            "financialYearEnds" => $organization->getFinancialYearEnds(),
            "fullTimeHoursPerWeek" => $organization->getFullTimePerWeek(),
            "businessHours" => $organization->getBusinessHours()
        ];

        $dateFounded = $organization->getDateFounded();
        if($dateFounded)
        {
            $foundedDate = $dateFounded->format('m/d/Y');
            $data["dateFounded"] = $foundedDate;
        } else {
            $data["dateFounded"] = '';
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Route("/delete/{id}", name="deleteOrganization", methods={"DELETE"})
    */
    public function deleteOrganization($id): JsonResponse
    {
        $organization = $this->organizationRepository->findOneBy(['id' => $id]);
        if(!$organization){
            return new JsonResponse(['status' => 'error', 'msg' => 'There was a problem with your submission.'], 500);
        }
        $this->organizationRepository->removeOrganization($organization);

        return new JsonResponse(['status' => 'success', 'msg' => 'The organization has been deleted successfully.'], Response::HTTP_OK);
    }

    /**
     * Route("/getAll", name="getOrganizationAll", methods={"GET"})
     */
    public function getOrganizationAll(): JsonResponse
    {
        // $this->organizationRepository->saveOrgLocation();

        $organizations = $this->organizationRepository->findAll();
        if(count($organizations) == 0){
            $data = [
                "organizations" => array()
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }

        $dataInner = array();
        foreach($organizations as $organization){
            $orgLocations = $this->organizationLocationRepository->findBy(['organization' => $organization]);

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
                "naicsMajor" => $organization->getIndustrySector(),
                "totalJobs" => $organization->getTotalEmployees(),
                "fte" => $organization->getFullTimePerWeek(),
                "locations" => $orgLocArray,
                "websiteURL" => $organization->getWebsiteUrl()
            ));
        }
        $data = [
            "organizations" => $dataInner
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Route("/getAll/{id}", name="getMyOrganization", methods={"GET"})
     */
    public function getMyOrganization($id): JsonResponse
    {
        $organizations = $this->organizationRepository->findBy(['owner' => $id]);
        if(count($organizations) == 0){
            $data = [
                "organizations" => array()
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }

        $dataInner = array();
        foreach($organizations as $organization){
            $lastUpdatedDate = $organization->getUpdatedAt();
            if($lastUpdatedDate){
                $lastUpdatedDate = $lastUpdatedDate->format("Y-m-d H:i:s");
            }
            array_push($dataInner, array(
                "id" => $organization->getId(),
                "name" => $organization->getName(),
                "lastUpdated" => $lastUpdatedDate,
                "lastUpdatedBy" => $organization->getUpdatedBy(),
                "websiteURL" => $organization->getWebsiteUrl()
            ));
        }
        $data = [
            "organizations" => $dataInner
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
