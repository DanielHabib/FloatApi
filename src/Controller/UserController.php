<?php

namespace FloatApi\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use FloatApi\Entity\User;
use Doctrine\ORM\EntityManager;
use FloatApi\Serializer\UserSerializer;
use FloatApi\Hydrator\UserHydrator;
use FloatApi\Repository\UserRepository;

class UserController extends AbstractController
{
    const ERROR_MESSAGE_UNABLE_TO_LOGIN = 'Unable to Log in, check your credentials';
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var UserSerializer
     */
    private $userSerializer;

    /**
     * @var UserHydrator
     */
    private $userHydrator;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param EntityManager  $entityManager
     * @param UserSerializer $userSerializer
     * @param UserHydrator   $userHydrator
     * @param UserRepository $userRepository
     */
    public function __construct(
        EntityManager $entityManager,
        UserSerializer $userSerializer,
        UserHydrator $userHydrator,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userSerializer = $userSerializer;
        $this->userHydrator = $userHydrator;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function login(Request $request, Response $response, $args = [])
    {
        // If fetch by email, confirm password
        $cookies = $request->getCookieParams();

        if (!array_key_exists('email', $cookies)  || !array_key_exists('email', $cookies)) {
            return $response->withStatus(401, self::ERROR_MESSAGE_UNABLE_TO_LOGIN);
        }

        $email = $cookies['email'];
        $password = $cookies['password'];

        /** @var User $user */
        $user = $this->userRepository->findOneBy(array('email' => $email));

        if ($user === null || $user->getPassword() !== $password) {
            return $response->withStatus(401, self::ERROR_MESSAGE_UNABLE_TO_LOGIN);
        }

        $json = json_encode(['logged_in' === true]);

        return $this->writeResponse($response, $json);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\MessageInterface
     */
    public function logout(Request $request, Response $response, $args = [])
    {
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Access-Control-Allow-Headers', 'Content-Type');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\MessageInterface
     */
    public function getArticlesWithUser(Request $request, Response $response, $args = [])
    {
        $id = $args['id'];
        $authorized = $this->checkAuth($request);
        if (!$authorized) {
            return $response->withStatus(401, self::ERROR_MESSAGE_UNAUTHORIZED);
        }
        /** @var User $user */
        $user = $this->userRepository->find($id);
        $json = json_encode($this->userSerializer->transform($user));

        return $this->writeResponse($response, $json);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\MessageInterface
     */
    public function createUser(Request $request, Response $response, $args = [])
    {
        $body = $this->getBody($request);

        // Hydrators
        $user = $this->userHydrator->hydrate($body);

        // Persist
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Serialize
        $responseJSON = json_encode($this->userSerializer->transform($user));

        return $this->writeResponse($response, $responseJSON)->withStatus(201);
    }
}
