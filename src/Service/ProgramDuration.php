<?php

namespace App\Service;

use App\Entity\Program;

class ProgramDuration
{

    public function calculate(Program $program): string
    {
        $totalDuration = 0;
        foreach ($program->getSeasons() as $season) {
            foreach ($season->getEpisodes() as $episode) {
                $totalDuration += $episode->getDuration();
            }
        }
        return $totalDuration;
    }
}
