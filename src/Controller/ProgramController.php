<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Form\ProgramType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/program', name: "program_")]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        if (!$session->has('total')) {
            $session->set('total', 0);
        }
        $total = $session->get('total');
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository)
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            $this->addFlash('success', 'nouvelle série crée');
        }
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'], name: 'show')]
    public function show(int $id, Program $program): Response
    {
        // $program = $programRepository->findOneBy(['id' => $id]);
        if (!$program) {
            throw $this->createNotFoundException("J'ai pas de série avec cet id " . $id);
        }
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route('/{programid}/season/{seasonid}', methods: ['GET'], name: 'season_show')]
    #[Entity('season', options: ['mapping' => ['seasonid' => 'id']])]
    #[Entity('program', options: ['mapping' => ['programid' => 'id']])]
    public function showSeason(Program $program, Season $season)
    {
        return $this->render('program/season_show.html.twig', [
            'season' => $season,
            'program' => $program,
        ]);
    }

    #[Route('/{program}/season/{season}/episode/{episode}', methods: ['GET'], name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', [
            'season' => $season,
            'program' => $program,
            'episode' => $episode,
        ]);
    }
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);
        }

        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }
}
