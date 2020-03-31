<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Movie;


class MovieController
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

// @Rest\Get("/movie")
    /**
     * Lists all Movies.
     * @Route("/movie", methods={"GET"})
     *
     * @return Response
     */
    public function getAll()
    {
        //Get all
        $movies = $this->em->getRepository(Movie::class)->findAll();

        //Check if the movie isn't empty
        if(!$movies)
        {
            return new Response(json_encode(["status"=>"There were no movies found"]), Response::HTTP_NOT_FOUND);
        }

        //Format $movie to json
        $data = $this->serializer->serialize($movies, 'json');

        return new Response($data);
    }

//    @Rest\Get("/movie/{id}")
    /**
     * Lists of one Movie.
     * @Route("/movie/{id}", methods={"GET","HEAD"})
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
        $movie = $this->em->getRepository(Movie::class)->findOneBy(['id' => $id]);

        //Check if the movie is empty
        if(!$movie)
        {
            return new Response(json_encode(["status"=>"There was no a movie found"]), Response::HTTP_NOT_FOUND);
        }

        //Format $movie to json
        $data = $this->serializer->serialize($movie, 'json');

        return new Response($data);
    }

//  @Rest\Post("/movie")
    /**
     * Create Movie.
     * @Route("/movie", methods={"POST"})
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

        //Make Response
        $response =
            [
                "status"=>"Created",
                "id"=>$movie->getId()
            ];

        //Format $response to json
        $response = $this->serializer->serialize($response, 'json');

        return new Response($response, Response::HTTP_CREATED);
    }

//  @Rest\Put("/movie/{id}")
    /**
     * Update Movie
     * @Route("/movie/{id}", methods={"PUT"})
     *
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
        $movie = $this->em->getRepository(Movie::class)->findOneBy(['id' => $id]);

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
        $response =
            [
                "status"=>"Updated",
                "id"=>$movie->getId()
            ];

        //Format $response to json
        $response = $this->serializer->serialize($response, 'json');

        return new Response($response, Response::HTTP_CREATED);
    }

//  @Rest\Delete("/movie/{id}")
    /**
     * Delete a Movie
     * @Route("/movie/{id}", methods={"DELETE"})
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
        $movie = $this->em->getRepository(Movie::class)->findOneBy(['id' => $id]);

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
        $response =
            [
                "status"=>"Deleted"
            ];

        //Format $response to json
        $response = $this->serializer->serialize($response, 'json');

        return new Response($response, Response::HTTP_CREATED);
    }
}