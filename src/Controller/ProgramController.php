<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/program', name: "program_")]
class ProgramController extends AbstractController
{

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'], name: 'show')]
    public function show(int $id = 4): Response
    {
        return $this->render('program/show.html.twig', ['id' => $id]);
    }
}
