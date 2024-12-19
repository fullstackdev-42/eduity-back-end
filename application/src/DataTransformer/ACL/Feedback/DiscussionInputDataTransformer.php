<?php
namespace App\DataTransformer\ACL;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Exception\InvalidArgumentException;
use App\DataTransformer\Traits\SafeClassnameTrait;
use App\Entity\Feedback\Discussion;

final class DiscussionInputDataTransformer implements DataTransformerInterface
{
    use SafeClassnameTrait;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;
    /** @var ParameterBagInterface */
    private $paramsBag;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $paramsBag)
    {
        $this->entityManager = $entityManager;
        $this->paramsBag = $paramsBag;
    }

    /**
     * @param Discussion $data
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $subjectClassname = $this->verifyClassname($data->getSubjectClassname(), 'Discussion.subjects');
        if ($subjectClassname === null) {
            throw new InvalidArgumentException("Subject name is not valid." , 400);
        }

        $data->setSubjectClassname($subjectClassname);

        return $data;
    }

    /**
     * @param SharingDTO $data
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof Discussion && Discussion::class === $to && null !== ($context['input']['class'] ?? null);
    }

}