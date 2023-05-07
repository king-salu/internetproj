<?php

namespace App\Controller;

use App\Entity\FbTeam;
use App\Entity\Players;
use App\Form\FbTeamType;
use App\Repository\FbTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/team', name: 'team.')]
class FbTeamController extends AbstractController
{
    #[Route('/fbteam', name: 'app_fb_team')]
    public function index(FbTeamRepository $Team): Response
    {
        $data = $Team->fetchWholeTeam();
        dd($data);

        return $this->render('fb_team/index.html.twig', [
            'controller_name' => 'FbTeamController',
        ]);
    }

    #[Route('/', name: 'create', methods: ['POST', 'GET'])]
    public function create(Request $req, EntityManagerInterface $em): Response
    {
        $fbteam = new FbTeam();
        $form_fb = $this->createForm(FbTeamType::class, $fbteam);
        $form_fb->handleRequest($req);

        if ($form_fb->isSubmitted()) {
            $em->persist($fbteam);
            $em->flush();
            $this->addFlash('success', $fbteam->getName() . ' Football team has been created successfully!');
            // return $this->render('fb_team/create.html.twig', ['form_fb' => $form_fb->createView(), 'form_ply' => $form_ply->createView()]);
        }

        return $this->render(
            'fb_team/create.html.twig',
            ['form_fb' => $form_fb->createView()]
        );
    }

    #[Route('/{tid}/buy/{id}', name: 'buy', methods: ['POST', 'GET'])]
    public function buyPlayer(Players $player, $tid, FbTeamRepository $fbteam, EntityManagerInterface $em): Response
    {
        $price = $player->getPrice();
        $FbTeam = $fbteam->findTeamByID($tid);
        $oldID = $player->getTeam();
        $player_Fteam = $fbteam->findTeamByID($oldID);

        //dd($FbTeam);
        if (($price <= $FbTeam->getBalance()) && ($FbTeam->getBalance() >= 0)) {
            //deduct from New
            $price = abs($price) * -1;
            $FbTeam->transact($price);
            $fbteam->save($FbTeam, true);

            //Add to Old
            $price = abs($price);
            $player_Fteam->transact($price);
            $fbteam->save($player_Fteam, true);

            $player->setTeam($tid);
            $em->persist($player);
            $em->flush();
            $this->addFlash('success', "Transfer successful!");
            //dd($player);
        } else $this->addFlash('failure', "Team doesn't have enough balance to purchase player");

        return $this->redirect($this->generateUrl('trade.populate', ["tidA" => $tid, "tidB" => $oldID]));
    }
}
