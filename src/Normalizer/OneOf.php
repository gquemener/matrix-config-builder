<?php

declare(strict_types=1);

namespace GQuemener\MatrixConfigBuilder\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use GQuemener\MatrixConfigBuilder\Model\Collection;

final class OneOf implements NormalizerInterface, NormalizerAwareInterface
{
    private $normalizer;

    public function setNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $tuples = [];
        foreach ($object as $req) {
            $tuples = array_merge($tuples, $this->normalizer->normalize($req, $format, $context));
        }

        return $tuples;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Collection && $data->isOneOf();
    }
}
