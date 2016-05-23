<?php

namespace FloatApi\Serializer;

use FloatApi\Entity\User;

class UserSerializer implements SerializerInterface
{
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

        return $data;
    }
}
