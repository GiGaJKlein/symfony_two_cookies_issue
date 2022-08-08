<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route("/")
     * @return Response
     */
    public function index()
    {
        return new Response("Hello World!");
    }

    /**
     * @Route("/login", name="app_login")
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        return new JsonResponse([
            "success" => true,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @return void
     */
    public function logout()
    {
        throw new \Exception("Should never be called.");
    }
}