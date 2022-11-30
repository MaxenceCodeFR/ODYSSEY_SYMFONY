<?php

namespace App\Controller;

use App\Entity\Program;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: "program_")]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'], name: 'show')]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        if (!$program) {
            throw $this->createNotFoundException("J'ai pas de série avec cet id " . $id);
        }
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route('/{programid}/seasons/{seasonid}', methods: ['GET'], name: 'season_show')]
    public function showSeason(int $programid, int $seasonid, ProgramRepository $programRepository, SeasonRepository $seasonRepository)
    {
        $program = $programRepository->findOneBy(
            ['id' => $programid],
        );
        $season = $seasonRepository->findOneBy(
            [
                'program' => $program,
                'id' => $seasonid,
            ]
        );

        return $this->render('program/season_show.html.twig', [
            'season' => $season,
            'program' => $program,
        ]);
    }
}
