<?php

namespace FloatApi\Hydrator;

use FloatApi\Hydrator\HydratorInterface;
use FloatApi\Entity\User;

class UserHydrator implements HydratorInterface
{
    /**
     * @param array $data
     * @return User
     */
    public static function hydrate($data)
    {

        $user = new User();

        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        return $user;
    }
}
