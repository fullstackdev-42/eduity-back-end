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

final class OrgApiDeleteController
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
        $organization = $this->em->getRepository(Organization::class)->findOneBy(['id' => $id]);
        if(!$organization){
            return new JsonResponse(['status' => 'error', 'msg' => 'There was a problem with your submission.'], 500);
        }
        $this->em->getRepository(Organization::class)->removeOrganization($organization);
        return new JsonResponse(['status' => 'success', 'msg' => 'The organization has been deleted successfully.'], 204);
    }
}