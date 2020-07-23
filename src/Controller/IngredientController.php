<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\IngredientMenuRepository;

/**
 * @Route("/ingredient")
 */

class IngredientController extends AbstractController
{
    /**
     * @Route("/{id}", name="ingredient_delete", methods={"DELETE"})
     */

    public function delete(Request $request, Ingredient $ingredient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ingredient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_edit', ['id' => $request->query->get('booking_id')]);
    }
}
