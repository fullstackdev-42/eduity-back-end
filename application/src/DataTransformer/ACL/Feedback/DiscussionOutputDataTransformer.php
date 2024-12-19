<?php
namespace App\DataTransformer\ACL;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DataTransformer\Traits\SafeClassnameTrait;
use App\Entity\Feedback\Discussion;

final class DiscussionOutputDataTransformer implements DataTransformerInterface
{
    use SafeClassnameTrait;

    /**
     * @param Discussion $data
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $data->setSubjectClassname($this->getSafeClassName($data->getSubjectClassname()));        
        return $data;
    }

    /**
     * @param Discussion $data
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof Discussion && Discussion::class === $to;
    }

}