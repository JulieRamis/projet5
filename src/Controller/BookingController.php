<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Ingredient;
use App\Entity\IngredientMenu;
use App\Form\BookingType;
use App\Form\IngredientMenuType;
use App\Repository\BookingRepository;
use App\Repository\IngredientMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/calendar", name="booking_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('booking/calendar.html.twig');
    }

    /**
     * @Route("/", name="booking_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        $user = $this->getUser();
        $user_menus = $this->getDoctrine()->getRepository(Booking::class)->findBy(['user' => $user]);
        $ingredientsMenu = [];


        foreach ($user_menus as $user_menu) {
            $menuIngredients = $user_menu->getIngredientMenus();
            foreach ($menuIngredients as $menuIngredient) {
                $ingredientsMenu[] = $menuIngredient;
            }
        }
       // dd($ingredientsMenu);
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findByUser($user),
            'ingredientMenu' => $ingredientsMenu
        ]);
    }

    /**
     * @Route("/list", name="shopping_list")
     */
    public function shoppingList(): Response
    {
        $user = $this->getUser();
          $user_menus = $this->getDoctrine()->getRepository(Booking::class)->findBy(['user' => $user]);
          $ingredientsMenu = [];


          foreach ($user_menus as $user_menu) {
              $menuIngredients = $user_menu->getIngredientMenus();
              foreach ($menuIngredients as $menuIngredient) {
                  $ingredientsMenu[] = $menuIngredient;
              }
          }
        // dd($ingredientsMenu);
        return $this->render('booking/list.html.twig', [
                'ingredientMenu' => $ingredientsMenu
            ]
        );
    }

    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $booking = new Booking();
        $user = $this->getUser();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {


        return $this->render('booking/show.html.twig', [
            'booking' => $booking
        ]);
    }

    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_index');
        }

        $ingredient=new IngredientMenu();

        $form2= $this->createForm(IngredientMenuType::class, $ingredient);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ingredient->setMenu($booking);
            $entityManager->persist($ingredient);
            $entityManager->flush();
        }



        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
            'form2' => $form2->createView()
        ]);
    }



    /**
     * @Route("/blabla", name="blabla")
     */
    public function blabla(){
        return $this->render('booking/blabla.html.twig');
    }


    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_index');
    }
}
