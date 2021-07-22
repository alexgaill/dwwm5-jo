<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Form\PaysType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @Route("/pays")
 */
class PaysController extends AbstractController
{
    /**
     * @Route("/", name="pays")
     *
     * @return Response
     */
    public function index(): Response
    {
        $pays = $this->getDoctrine()->getRepository(Pays::class)->findAll();

        return $this->render('pays/index.html.twig', [
            'pays' => $pays
        ]);
    }

    /**
     * @Route("/create", name="createPays")
     */
    public function create(Request $request)
    {
        $pays = new Pays;
        $form = $this->createForm(PaysType::class, $pays);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $pays = $form->getData();

                $drapeau = $request->files->get("pays")["drapeau"];

                $drapeau->move(
                    $this->getParameter("upload_country"),
                    $drapeau->getClientOriginalName()
                );
                $pays->setDrapeau($drapeau->getClientOriginalName());

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($pays);
                $manager->flush();

                $this->addFlash("success", "Pays ajouté correctement!");
                return $this->redirectToRoute("pays");
            } catch (\Exception $e) {
               $this->addFlash("danger", $e->getMessage());
            }
        }

        return $this->render("pays/create.html.twig",[
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/update", name="updatePays")
     */
    public function update(Pays $pays, Request $request)
    {
        if ($pays->getDrapeau() !== null) {
            $pays->setDrapeau( new File($this->getParameter('upload_country').'/'.$pays->getDrapeau()));
        }
        dump($pays);

        $form = $this->createForm(PaysType::class, $pays);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $pays = $form->getData();

                if ($request->files->get("pays")["drapeau"] !== null) {
                    $drapeau = $request->files->get("pays")["drapeau"];
                    
                    $drapeau->move(
                        $this->getParameter("upload_country"),
                        $drapeau->getClientOriginalName()
                    );
                    $pays->setDrapeau($drapeau->getClientOriginalName());
                }

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($pays);
                $manager->flush();

                $this->addFlash("success", "Pays ajouté correctement!");
                return $this->redirectToRoute("pays");
            } catch (\Exception $e) {
               $this->addFlash("danger", $e->getMessage());
            }
        }

        return $this->render("pays/update.html.twig", [
            'form' => $form->createView(),
            "pays" => $pays
        ]);
    }

    /**
     * @Route("/{id}/delete", name="deletePays")
     */
    public function delete(Pays $pays)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($pays);
        $em->flush();

        return $this->redirectToRoute("pays");
    }
}
