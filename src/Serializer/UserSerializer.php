<?php

namespace FloatApi\Serializer;

use FloatApi\Entity\User;
use FloatApi\Behavior\Transformer\Date\TransformsCreatedDate;
use FloatApi\Behavior\Transformer\Date\TransformsUpdatedDate;

class UserSerializer implements SerializerInterface
{
    use TransformsCreatedDate;
    use TransformsUpdatedDate;
    /**
     * @param User $user
     *
     * @return array
     */
    public function transform($user)
    {
        // Do NOT seriaize the password
        $data = [

            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ];

        $this->transformCreatedDate($data, $user->getCreatedDate());
        $this->transformUpdatedDate($data, $user->getUpdatedDate());

        return $data;
    }
}
