<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;
use App\Repository\UserRepositoryInterface;
use App\Util\JwtUtilInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @author Mike ten Klooster <mike.tenklooster001@fclive.nl> <226751> <25187> <Applicatie Ontwikkeling>
 * @version 3
 *
 * Class LoginController
 * @package App\Controller
 */
class LoginController
{
    private $tokenRepository;
    private $userRepository;
    private $entityManager;
    private $userPasswordEncoder;
    private $jwtUtil;
    private $jwtTtl;

    /**
     * LoginController constructor.
     * @param TokenRepository $tokenRepository
     * @param UserRepositoryInterface $userRepository
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param JwtUtilInterface $jwtUtil
     * @param string $jwtTtl
     */
    public function __construct(
        TokenRepository $tokenRepository,
        UserRepositoryInterface $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $userPasswordEncoder,
        JwtUtilInterface $jwtUtil,
        string $jwtTtl
    ) {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->jwtUtil = $jwtUtil;
        $this->jwtTtl = $jwtTtl;
    }

    /**
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function login(Request $request): Response
    {
        $test = $this->tokenRepository->findOneByData(substr($request->headers->get('Authorization'), 7)) ?? "";
        if($test instanceof Token)
        {
            if($test->getExpiresAt() >= (new DateTime())->format(DATE_ISO8601))
            {
                $test_user = $this->userRepository->findOneActiveById($test->getId());
                $this->jwtTtl = "5 minutes";
                $createdAt = (new DateTime())->format(DATE_ISO8601);
                $expiresAt = (new DateTime())->modify($this->jwtTtl)->format(DATE_ISO8601);

                $test_tokenData = [
                    'id' => $test->getId(),
                    'created_at' => $createdAt,
                    'expires_at' => $expiresAt,
                    'user' => [
                        'id' => $test_user->getId(),
                        'roles' => $test_user->getRoles(),
                    ],
                ];

                if($request->headers->has('Authorization') &&
                    0 === strpos($request->headers->get('Authorization'), 'Bearer ') && $test)
                {
                    $test->setCreatedAt($createdAt);
                    $test->setExpiresAt($expiresAt);
                    $test->setData($this->jwtUtil->encode($test_tokenData));
                    $this->entityManager->persist($test);
                    $this->entityManager->flush();

                    return new Response($test->getData(), Response::HTTP_CREATED);
                }
            }
        }

        $data = json_decode($request->getContent(), true);

        //check if there is a username and password
        if(!$data['username'] || !$data['password'])
        {
            throw new UnauthorizedHttpException('Basic realm="API Login"', 'No credentials given.');
        }

        //find user by username
        $user = $this->userRepository->findOneActiveByUsername($data['username']);
        //check if the given user and password are correct
        if (
            !$user instanceof User ||
            !$this->userPasswordEncoder->isPasswordValid($user, $data['password'])
        ) {
            throw new UnauthorizedHttpException('Basic realm="API Login"', 'Invalid credentials.');
        }

//        $id = Uuid::uuid4()->toString();
        $id = $user->getId();
        $this->jwtTtl = "5 minutes";
        $createdAt = (new DateTime())->format(DATE_ISO8601);
        $expiresAt = (new DateTime())->modify($this->jwtTtl)->format(DATE_ISO8601);

        $tokenData = [
            'id' => $id,
            'created_at' => $createdAt,
            'expires_at' => $expiresAt,
            'user' => [
                'id' => $user->getId(),
                'roles' => $user->getRoles(),
            ],
        ];

        $token_id = $this->entityManager->getRepository(Token::class)->findOneBy(['id' => $id]);

        if(!$token_id == $id)
        {
            $token = new Token();
            $token->setId($id);
            $token->setCreatedAt($createdAt);
            $token->setExpiresAt($expiresAt);
            $token->setUser($user);
            $token->setData($this->jwtUtil->encode($tokenData));
        } else {
            $token_id->setCreatedAt($createdAt);
            $token_id->setExpiresAt($expiresAt);
            $token_id->setData($this->jwtUtil->encode($tokenData));
        }

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return new Response($token->getData(), Response::HTTP_CREATED);
    }

//    /**
//     * checks if there is a token, if so refresh / update it
//     *
//     * @param $jwt_token
//     * @param Request $request
//     * @return Response
//     * @throws Exception
//     */
//    public function check_token($jwt_token, Request $request): Response
//    {
//        $this_token = $this->tokenRepository->findOneByData($jwt_token);
//        $this_user  = $this->userRepository->findOneActiveById($this_token->getId());
//
//        if($this_token->getExpiresAt() >= (new DateTime())->format(DATE_ISO8601))
//        {
//            return;
//        }
//
//        $createdAt = (new DateTime())->format(DATE_ISO8601);
//        $expiresAt = (new DateTime())->modify('5 minutes')->format(DATE_ISO8601);
//
//        $this_tokenData = [
//            'id' => $this_token->getId(),
//            'created_at' => $createdAt,
//            'expires_at' => $expiresAt,
//            'user' => [
//                'id' => $this_user->getId(),
//                'roles' => $this_user->getRoles(),
//            ],
//        ];
//
//        if($request->headers->has('Authorization') &&
//            0 === strpos($request->headers->get('Authorization'), 'Bearer ') && $this_token)
//        {
//            $this_token->setCreatedAt($createdAt);
//            $this_token->setExpiresAt($expiresAt);
//            $this_token->setData($this->jwtUtil->encode($this_tokenData));
//            $this->entityManager->persist($this_token);
//            $this->entityManager->flush();
//
//            return new Response($this_token->getData(), Response::HTTP_CREATED);
//        }
//    }
}