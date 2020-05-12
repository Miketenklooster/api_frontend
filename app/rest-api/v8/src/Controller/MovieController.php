<?php

namespace App\Controller;

//use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Movie;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @author Mike ten Klooster <mike.tenklooster001@fclive.nl> <226751> <25187> <Applicatie Ontwikkeling>
 * @version 8
 *
 * Class MovieController
 * @package App\Controller
 */
class MovieController extends AbstractFOSRestController
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
     * MovieController constructor.
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em           = $em;
        $this->serializer   = $serializer;
    }

    /**
     * Lists all Movies.
     * @Rest\Get("/movie")
     *
     * @return Response
     */
    public function getAll()
    {
        //Get all
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();

        //Check if the movie isn't empty
        if(!$movies)
        {
            return new Response(json_encode(["status"=>"There were no movies found"]), Response::HTTP_NOT_FOUND);
        }

        $msg = [
            "status"=>"getAll",
            "message"=> $movies,
            "access_token"=> $this->getUser()->getApiToken()
        ];

        return new Response(json_encode($msg));
    }

    /**
     * Lists of one Movie.
     * @Rest\Get("/movie/{id}")
     *
     * @param $id
     * @return Response
     */
    public function getOneById($id)
    {
        //Check if the id is empty
        if(!$id)
        {
            return new Response(json_encode(["status"=>"No id found"]),Response::HTTP_NOT_FOUND);
        }

        //Get Movie id
        $movie = $this->getDoctrine()->getRepository(Movie::class)->findOneBy(['id' => $id]);

        //Check if the movie is empty
        if(!$movie)
        {
            return new Response(json_encode(["status"=>"There was no a movie found"]), Response::HTTP_NOT_FOUND);
        }

        $msg = [
            "status"=>"getOne",
            "message"=> $movie,
            "access_token"=> $this->getUser()->getApiToken()
        ];

        return new Response(json_encode($msg));
    }

    /**
     * Create Movie.
     * @Rest\Post("/movie")
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        //Make new Entity Movie
        $movie = new Movie();

        //Check if the name and the description are empty
        if(!$request->request->has('name') || !$request->request->has('description'))
        {
            return new Response(json_encode(["status"=>"Not all parameters were given"]), Response::HTTP_BAD_REQUEST);
        }

        //set the name and description
        $movie->setName($request->get('name'));
        $movie->setDescription($request->get('description'));

        //this builds a new query
        $this->em->persist($movie);

        //this executes the query
        $this->em->flush();

        $msg = [
            "status"=>"Create",
            "message"=> $movie,
            "access_token"=> $this->getUser()->getApiToken()
        ];

        //Format $response to json
        return new Response(json_encode($msg), Response::HTTP_CREATED);
    }

    /**
     * Update Movie
     * @Rest\Put("/movie/{id}")
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
            return new Response(json_encode(["status"=>"No id found"]),Response::HTTP_BAD_REQUEST);
        }

        //Get movie by id
        $movie = $this->getDoctrine()->getRepository(Movie::class)->findOneBy(['id' => $id]);

        //Check if the movie is empty
        if(!$movie)
        {
            return new Response(json_encode(["status"=>"There was no a movie found"]), Response::HTTP_NOT_FOUND);
        }

        //Check if the name and the description are empty
        if(!$request->request->has('name') || !$request->request->has('description'))
        {
            return new Response(json_encode(["status"=>"Not all parameters were given"]), Response::HTTP_BAD_REQUEST);
        }

        //set the name and description
        $movie->setName($request->get('name'));
        $movie->setDescription($request->get('description'));

        //this executes the query
        $this->em->flush();

        //Make Response
        $msg = [
            "status"=>"Update",
            "message"=> $movie,
            "access_token"=> $this->getUser()->getApiToken()
        ];

        return new Response(json_encode($msg), Response::HTTP_CREATED);
    }

    /**
     * Delete a Movie
     * @Rest\Delete("/movie/{id}")
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
            return new Response(json_encode(["status"=>"No id found"]),Response::HTTP_BAD_REQUEST);
        }

        //Get movie
        $movie = $this->getDoctrine()->getRepository(Movie::class)->findOneBy(['id' => $id]);

        //Check if the movie is exists
        if(!$movie)
        {
            return new Response(json_encode(["status"=>"There was no a movie found"]), Response::HTTP_NOT_FOUND);
        }

        //This will prepare a query to remove this movie(id)
        $this->em->remove($movie);

        //This executes the query
        $this->em->flush();

        //Make Response
        $msg = [
            "status"=>"Deleted",
            "access_token"=> $this->getUser()->getApiToken()
        ];

        return new Response(json_encode($msg), Response::HTTP_CREATED);
    }
}
