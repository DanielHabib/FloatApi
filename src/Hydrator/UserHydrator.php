<?php

namespace FloatApi\Hydrator;

use FloatApi\Entity\User;
use FloatApi\Repository\UserRepository;

class UserHydrator implements HydratorInterface
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     *
     * @return User
     */
    public function hydrate($data)
    {
        if (array_key_exists('id', $data)) {
            /** @var User $user */
            $user = $this->userRepository->find($data['id']);
            if (array_key_exists('name', $data)) {
                $user->setName($data['name']);
            }
            if (array_key_exists('email', $data)) {
                $user->setEmail($data['email']);
            }
            if (array_key_exists('name', $data)) {
                $user->setName($data['name']);
            }

            return $user;
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        return $user;
    }
}
