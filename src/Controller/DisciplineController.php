<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Form\DisciplineType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/discipline")
 */
class DisciplineController extends AbstractController
{
    /**
     * @Route("/", name="discipline")
     *
     * @return Response
     */
    public function index(): Response
    {
        $disciplines = $this->getDoctrine()->getRepository(Discipline::class)->findAll();

        return $this->render('discipline/index.html.twig', [
            'disciplines' => $disciplines
        ]);
    }

    /**
     * @Route("/create", name="createDiscipline")
     */
    public function create(Request $request)
    {
        $discipline = new Discipline;
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $discipline = $form->getData();
                $discipline->setNombreCandidats(0);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($discipline);
                $manager->flush();

                $this->addFlash("success", "Discipline ajoutée correctement!");
                return $this->redirectToRoute("discipline");
            } catch (\Exception $e) {
               $this->addFlash("danger", $e->getMessage());
            }
        }

        return $this->render("discipline/create.html.twig",[
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/update", name="updateDiscipline")
     */
    public function update(Discipline $discipline, Request $request)
    {

        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $discipline = $form->getData();

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($discipline);
                $manager->flush();

                $this->addFlash("success", "Discipline modifiée correctement!");
                return $this->redirectToRoute("discipline");
            } catch (\Exception $e) {
               $this->addFlash("danger", $e->getMessage());
            }
        }

        return $this->render("discipline/update.html.twig", [
            'form' => $form->createView(),
            "discipline" => $discipline
        ]);
    }

    /**
     * @Route("/{id}/delete", name="deleteDiscipline")
     */
    public function delete(Discipline $discipline)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($discipline);
        $em->flush();

        return $this->redirectToRoute("discipline");
    }
}
