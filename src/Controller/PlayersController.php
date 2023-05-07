<?php

namespace App\Controller;

use App\Entity\Players;
use App\Form\PlayersType;
use App\Repository\FbTeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/players', name: 'players.')]
class PlayersController extends AbstractController
{

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $req, FbTeamRepository $FbTeam): Response
    {

        $player = new Players();
        $form_ply = $this->createForm(PlayersType::class, $player);

        return $this->render('players/index.html.twig', ['form' => $form_ply->createView()]);
    }


    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(Request $req, EntityManagerInterface $em)
    {
        //dd($req);
        $player = new Players();
        $form_ply = $this->createForm(PlayersType::class, $player);
        $postdata = $req->request->all();
        if (!empty($postdata['players'])) {
            $postinfo = $postdata['players'];
            $player->setFirstname($postinfo['firstname']);
            $player->setSurname($postinfo['surname']);
            $player->setPrice($postinfo['price']);
            $player->setTeam($postinfo['team']);

            $em->persist($player);
            $em->flush();
            $this->addFlash('success', $player->getName() . ' player has been created successfully!');
        } else $this->addFlash('failure', ' insufficient data   !');

        return $this->render('players/index.html.twig', ['form' => $form_ply->createView()]);
    }
}
