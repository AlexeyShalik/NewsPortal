<?php

namespace AppBundle\Services\JSONSerializer;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class JsonSerializer
{
    public function getJson($response)
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format(\DateTime::ISO8601)
                : '';
        };

        $normalizer->setCallbacks(array('year' => $callback));

        $serializer = new Serializer(array($normalizer), array($encoder));

        $jsonContent = $serializer->serialize($response, 'json');

        return $jsonContent;
    }
}
