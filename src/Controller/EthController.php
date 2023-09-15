<?php

namespace App\Controller;

use App\Entity\Eth;
use App\Repository\EthRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/eth')]
class EthController extends AbstractController
{

    #[Route('/', name: 'app_eth_index')]
    public function indexAPI(EthRepository $ethRepository): Response
    {
        $eths = $ethRepository->findAll();
        return $this->json($eths, 200, [], []);
    }

    #[Route('/new', name: 'app_eth_new', methods: ['POST'])]
    public function newAPI(Request $request, EntityManagerInterface $entityManager): Response
    {

        $data = json_decode($request->getContent(), true);

        if(!isset($data['price']) || !isset($data['date'])){
            return new Response();
        }

        if($data["price"] ==! null && $data["date"] ==! null){

            $datePost = $data["date"];
            $datePost = date_parse_from_format("Y-m-d", $datePost);

            $date = new DateTime();
            $date->setDate($datePost["year"],$datePost["month"],$datePost["day"]);

            $eth = new Eth();
            $eth->setPrice($data["price"]);
            $eth->setDate($date);

            $entityManager->persist($eth);
            $entityManager->flush();

            return new Response();
        }else{
            return new Response();
        }
    }

    #[Route('/{id}', name: 'app_eth_show', methods: ['GET'])]
    public function showAPI($id, EthRepository $ethRepository): Response
    {
        $eth = $ethRepository->find($id);
        return $this->json($eth, 200, [], []);
    }

    #[Route('/{id}/edit', name: 'app_eth_edit', methods: ['PUT'])]
    public function editAPI($id, EthRepository $ethRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $data = json_decode($request->getContent(), true);
        $eth = $ethRepository->find($id);

        $datePost = $data["date"];
        $datePost = date_parse_from_format("j/n/Y", $datePost);

        $date = new DateTime();
        $date->setDate($datePost["year"],$datePost["month"],$datePost["day"]);

        if($data["price"] == $eth->getPrice()){
            new Response();
            
        }else{
            $eth->setPrice($data["price"]);
            new Response();
        }

        if($data["date"] == $eth->getDate()->format('d/m/Y')){
            new Response();
            
        }else{
            $eth->setDate($date);
            new Response();
        }

        $entityManager->flush();

        return new Response();
    }

    #[Route('/{id}', name: 'app_eth_delete', methods: ['DELETE'])]
    public function deleteAPI($id, EthRepository $ethRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $eth = $ethRepository->find($id);

        $entityManager->remove($eth);
        $entityManager->flush();

        return new Response();
    }
}
