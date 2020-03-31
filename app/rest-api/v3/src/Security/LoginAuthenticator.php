<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * @author Mike ten Klooster <mike.tenklooster001@fclive.nl> <226751> <25187> <Applicatie Ontwikkeling>
 * @version 3
 *
 * Class LoginAuthenticator
 * @package App\Security
 */
class LoginAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * TokenAuthenticator constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em              = $em;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        if (($request->getPathInfo() == '/api/v3/login' || $request->isMethod('POST')) && ($request->headers->has('Authorization') && 0 === strpos($request->headers->get('Authorization'), 'Basic '))) {
            return true;
        }
        return false;
    }

    /**
     * @param Request $request
     * @return false|mixed|string
     */
    public function getCredentials(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');

        // skip beyond "Basic "
        return substr($authorizationHeader, 6);
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return object|UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (null === $credentials) {
            // The token header was empty, authentication fails with 401
            return null;
        }
        $arr_credentials = explode(":", base64_decode($credentials));

        // if a User is returned, checkCredentials() is called
        return $this->em->getRepository(User::class)
            ->findOneBy(['email' => $arr_credentials[0]]);
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $arr_credentials = explode(":", base64_decode($credentials));

        return $this->passwordEncoder->isPasswordValid($user, $arr_credentials[1]);
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse|Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'status'  =>  'Unauthorized',
            'message' =>  'An authentication exception occurred.'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return Response|void|null
     * @throws \Exception
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $newToken = new Token();
        $user = $token->getUser();

        $user->setApiToken($newToken->generate($user));
        $user->setTokenExpiresAt(new \DateTime("+5min"));
        $this->em->flush();

        $data = [
            "message" => "Login Successful",
            "access_token" => $user->getApiToken()
        ];

        return new Response(json_encode($data), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return JsonResponse|Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'status'  =>  'Unauthorized',
            'message' => 'Basic Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
