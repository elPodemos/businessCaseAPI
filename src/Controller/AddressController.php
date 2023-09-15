<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/address')]
class AddressController extends AbstractController
{
    // #[Route('/', name: 'app_address_index', methods: ['GET'])]
    // public function index(AddressRepository $addressRepository): Response
    // {
    //     return $this->render('address/index.html.twig', [
    //         'addresses' => $addressRepository->findAll(),
    //     ]);
    // }

    #[Route('/', name: 'app_address_index', methods: ['GET'])]
    public function indexAPI(AddressRepository $addressRepository): Response
    {
        $address = $addressRepository->findAll();
        return $this->json($address, 200, [], ['groups' => 'allAddress']);
    }

    // #[Route('/new', name: 'app_address_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $address = new Address();
    //     $form = $this->createForm(AddressType::class, $address);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($address);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('address/new.html.twig', [
    //         'address' => $address,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/new', name: 'app_address_new', methods: ['POST'])]
    public function newAPI(Request $request, EntityManagerInterface $entityManager): Response
    {

        $data = json_decode($request->getContent(), true);

        var_dump($data);

        if(!isset($data['label']) || !isset($data['postalCode']) || !isset($data['country'])){
            return new Response();
        }

        if($data["label"] ==! null && $data["postalCode"] ==! null && $data["country"] ==! null){

            $address = new Address();

            $address->setLabel($data['label']);
            $address->setPostalCode($data['postalCode']);
            $address->setCountry($data['country']);

            $entityManager->persist($address);
            $entityManager->flush();

            return new Response();

        }else{
            return new Response();
        }
    }


    // #[Route('/{id}', name: 'app_address_show', methods: ['GET'])]
    // public function show(Address $address): Response
    // {
    //     return $this->render('address/show.html.twig', [
    //         'address' => $address,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_address_show', methods: ['GET'])]
    public function show($id, AddressRepository $addressRepository): Response
    {
        $address = $addressRepository->find($id);
        return $this->json($address, 200, [], ['groups' => 'oneAddress']);
    }

    #[Route('/{id}/edit', name: 'app_address_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Address $address, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('address/edit.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_address_delete', methods: ['POST'])]
    public function delete(Request $request, Address $address, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
            $entityManager->remove($address);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
    }
}
