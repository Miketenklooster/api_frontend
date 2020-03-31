<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mike ten Klooster <mike.tenklooster001@fclive.nl> <226751> <25187> <Applicatie Ontwikkeling>
 * @version 3
 *
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractFOSRestController
{
    /**
     * @Rest\POST("/login")
     */
    public function Login()
    {
        return new Response(json_encode(["message"=>"There were no credentials given"]), Response::HTTP_NOT_FOUND);
    }
}
