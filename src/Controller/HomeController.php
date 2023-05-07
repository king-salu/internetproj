<?php

namespace App\Controller;

use App\Repository\FbTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(FbTeamRepository $FbTeam, Request $req): Response
    {
        $page = $req->query->get('page');
        $pagination = [];
        $selectedTeam = "";
        if (!empty($page)) {
            $page_arr = explode(',', $page);
            if (isset($page_arr[0]))
                $selectedTeam =          $pagination['teamid']      = $page_arr[0];
            if (isset($page_arr[1])) $pagination['page_no']     = $page_arr[1];
            if (isset($page_arr[2])) $pagination['recsperpage'] = $page_arr[2];
        }
        $fbteams = $FbTeam->fetchWholeTeam($pagination);

        return $this->render('home/home.html.twig', [
            'fullteams' => $fbteams, 'DisplayTeam' => $selectedTeam
        ]);
    }
}
