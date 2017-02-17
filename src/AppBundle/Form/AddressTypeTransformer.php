<?php

namespace AppBundle\Form;

use AppBundle\Entity\Address;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AddressTypeTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if (! ($value instanceof Address)) {
            throw new TransformationFailedException('Can only handle Address entities');
        }

        if ($value->getId() != 0) {
            return [
                'address_id' => $value->getId(),
                'address_fields' => []
            ];
        }

        return [
            'address_id' => null,
            'address_fields' => $value
        ];
    }

    public function reverseTransform($value)
    {
        if (! is_array($value)) {
            throw new TransformationFailedException('Can only handle arrays');
        }

        if (isset($value['address_id']) && $value['address_id'] != 0) {
            return $this->getAddresseFromRepo($value['address_id']);
        }

        return $value['address_fields'];
    }

    protected function getAddresseFromRepo($id)
    {
        // should fetch data from DB but not needed for example
        $address = new Address();
        $address->setId($id);

        return $address;
    }
}
