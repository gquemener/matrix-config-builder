<?php

declare(strict_types=1);

namespace GQuemener\MatrixConfigBuilder\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use GQuemener\MatrixConfigBuilder\Model;

final class Variant implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        $tuples = [];
        $name = $object->name();
        foreach ($object->variants() as $variant) {
            $tuples[] = [$name => $variant];
        }

        return $tuples;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Model\Variant;
    }
}
