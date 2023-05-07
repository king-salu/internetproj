<?php

namespace App\Controller;

use App\Form\TradeType;
use App\Entity\FbTeam;
use App\Repository\FbTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trade', name: 'trade.')]
class TradeController extends AbstractController
{
    #[Route('/', name: 'market', methods: ['GET'])]
    public function index(FbTeamRepository $FbTeam): Response
    {
        $teamsonly = $FbTeam->findAll();
        return $this->render('trade/index.html.twig', ['team_dd' => $teamsonly, 'fullteamsA' => [], 'fullteamsB' => []]);
    }

    #[Route('/{tidA}/{tidB}', name: 'populate', methods: ['GET'])]
    public function populate($tidA, $tidB, FbTeamRepository $FbTeam): Response
    {
        $teamsonly = $FbTeam->findAll();
        $fmain = $FbTeam->fetchWholeTeam();

        $fbteamA = (isset($fmain[$tidA])) ? $fmain[$tidA] : [];
        // dd($fbteamA);
        //$fbteamB = $FbTeam->findTeamByID($tidB);
        $fbteamB = (isset($fmain[$tidB])) ? $fmain[$tidB] : [];
        return $this->render('trade/index.html.twig', ['team_dd' => $teamsonly, 'fullteamsA' => $fbteamA, 'fullteamsB' => $fbteamB]);
    }
}
