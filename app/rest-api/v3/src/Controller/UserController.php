<?php

namespace App\Controller;

use App\Security\Token;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @author Mike ten Klooster <mike.tenklooster001@fclive.nl> <226751> <25187> <Applicatie Ontwikkeling>
 * @version 3
 *
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em               = $em;
        $this->serializer       = $serializer;
        $this->passwordEncoder  = $passwordEncoder;
    }

    /**
     * Lists all Users.
     * @Rest\Get("/user")
     *
     * @return Response
     */
    public function getAll()
    {
        //Get all
        $users = $this->em->getRepository(User::class)->findAll();

        //Check if the user isn't empty
        if(!$users)
        {
            return new Response(json_encode(["message"=>"There were no users found"]), Response::HTTP_NOT_FOUND);
        }

        //Format $user to json
        $data = $this->serializer->serialize($users, 'json');

        return new Response($data);
    }

    /**
     * Lists of one User.
     * @Rest\Get("/user/{id}")
     *
     * @param $id
     * @return Response
     */
    public function getOneById($id)
    {
        //Check if the id exists
        if(!$id)
        {
            return new Response(json_encode(["message"=>"No id found"]),Response::HTTP_NOT_FOUND);
        }

        //Get User id
        $user = $this->em->getRepository(User::class)->find($id);

        //Check if the user exists
        if(!$user)
        {
            return new Response(json_encode(["message"=>"There was no a user found"]), Response::HTTP_NOT_FOUND);
        }

        //Format $user to json
        $data = $this->serializer->serialize($user, 'json');

        return new Response($data);
    }

    /**
     * Create User.
     * @Rest\Post("/user")
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        //Check if the first_name, email and the password aren't empty
        if(!$request->request->has('first_name') || !$request->request->has('email') || !$request->request->has('password'))
        {
            return new Response(json_encode(["message"=>"Not all parameters were given"]), Response::HTTP_BAD_REQUEST);
        }

        //Make new Entity User
        $user = new User();
        $token = new Token();

        //set the name and description
        $user->setEmail($request->get('email'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, $request->get('password')));
        $user->setFirstName($request->get('first_name'));
        $user->setCreatedAt(new \DateTime('now'));
        $user->setApiToken($token->generate($user));
        $user->setTokenExpiresAt(new \DateTime('+5min'));

        //this builds a new query
        $this->em->persist($user);

        //this executes the query
        $this->em->flush();

        //Make Response
        $response =
            [
                "status" => "Created",
                "id"     =>$user->getId()
            ];

        return new Response(json_encode($response), Response::HTTP_CREATED);
    }

    /**
     * Update User
     * @Rest\Put("/user/{id}")
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //Check if the id is empty
        if(!$id)
        {
            return new Response(json_encode(["message"=>"No id found"]),Response::HTTP_BAD_REQUEST);
        }

        //Check if the first_name, email and the password aren't empty
        if(!$request->request->has('first_name') || !$request->request->has('email') || !$request->request->has('password'))
        {
            return new Response(json_encode(["message"=>"Not all parameters were given"]), Response::HTTP_BAD_REQUEST);
        }

        //Get user by id
        $user = $this->em->getRepository(User::class)->find($id);

        //Check if the user is empty
        if(!$user)
        {
            return new Response(json_encode(["message"=>"There was no a user found"]), Response::HTTP_NOT_FOUND);
        }

        //set the parameters
        $user->setEmail($request->get('email'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, $request->get('password')));
        $user->setFirstName($request->get('first_name'));

        //this executes the query
        $this->em->flush();

        //Make Response
        $response =
            [
                "status" => "Updated",
                "id"     => $user->getId()
            ];

        return new Response(json_encode($response), Response::HTTP_CREATED);
    }

    /**
     * Delete a User
     * @Rest\Delete("/user/{id}")
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        //Check if the id is empty
        if(!$id)
        {
            return new Response(json_encode(["message"=>"No id found"]),Response::HTTP_BAD_REQUEST);
        }

        //Get user
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $id]);

        //Check if the user is exists
        if(!$user)
        {
            return new Response(json_encode(["message"=>"There was no a user found"]), Response::HTTP_NOT_FOUND);
        }

        //This will prepare a query to remove this user(id)
        $this->em->remove($user);

        //This executes the query
        $this->em->flush();

        //Make Response
        $response =
            [
                "status" => "Deleted"
            ];

        return new Response(json_encode($response), Response::HTTP_CREATED);
    }
}
