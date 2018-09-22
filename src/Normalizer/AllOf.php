<?php

declare(strict_types=1);

namespace GQuemener\MatrixConfigBuilder\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use GQuemener\MatrixConfigBuilder\Model\Collection;

final class AllOf implements NormalizerInterface, NormalizerAwareInterface
{
    private $normalizer;

    public function setNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $set = new \MathPHP\SetTheory\Set($this->normalizer->normalize($object->current(), $format, $context));
        $object->next();
        while ($object->valid()) {
            $set = $set->cartesianProduct(
                new \MathPHP\SetTheory\Set($this->normalizer->normalize($object->current(), $format, $context))
            );
            $object->next();
        }

        $tuples = array_map(function(\MathPHP\SetTheory\Set $set) {
            return array_reduce($set->asArray(), 'array_merge', []);
        }, array_values($set->asArray()));

        return $tuples;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Collection && $data->isAllOf();
    }
}
