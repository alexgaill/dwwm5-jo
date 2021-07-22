<?php

namespace App\Controller;

use App\Entity\Athlete;
use App\Form\AthleteType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/athlete")
 */
class AthleteController extends AbstractController
{
    /**
     * @Route("/", name="athletes")
     */
    public function index(): Response
    {
        $athletes = $this->getDoctrine()->getRepository(Athlete::class)->findAll();

        return $this->render('athlete/index.html.twig', [
            'athletes' => $athletes,
        ]);
    }

    /**
     * @Route("/create", name="createAthlete")
     */
    public function create(Request $request)
    {
        $athlete = new Athlete;
        $form = $this->createForm(AthleteType::class, $athlete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
            $athlete = $form->getData();
            $discipline = $athlete->getDiscipline();
            $nbCandidats = $discipline->getNombreCandidats() +1;
            $discipline->setNombreCandidats($nbCandidats);
            $athlete->setDiscipline($discipline);

            $photo = $athlete->getPhoto();
            $photoName = md5(uniqid()). ".". $photo->guessExtension();

            $photo->move(
                $this->getParameter("upload_profil"),
                $photoName
            );
            $athlete->setPhoto($photoName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($athlete);
            $em->flush();
            $this->addFlash("success", "Athlète créé");

            return $this->redirectToRoute("athletes");
            } catch( Exception $e) {
                $this->addFlash("danger", $e->getMessage());
            }

        }

        return $this->render("athlete/create.html.twig",[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/update", name="updateAthlete")
     */
    public function update(Athlete $athlete, Request $request)
    {
        if ($athlete->getOldDiscipline() === null) {
            $athlete->setOldDiscipline($athlete->getDiscipline());
        }

        if ($athlete->getOldPhoto() === null) {
            $athlete->setOldPhoto($athlete->getPhoto());
        }
        dump($athlete);
        $athlete->setPhoto(new File($this->getParameter("upload_profil") ."/" . $athlete->getPhoto()));
        

        $form = $this->createForm(AthleteType::class, $athlete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $athlete = $form->getData();
            $discipline = $athlete->getDiscipline();
            $oldDiscipline = $athlete->getOldDiscipline();
            $nbCandidats = $discipline->getNombreCandidats() +1;
            $oldNbCandidats = $oldDiscipline->getNombreCandidats() -1;
            $discipline->setNombreCandidats($nbCandidats);
            $oldDiscipline->setNombreCandidats($oldNbCandidats);
            $athlete->setDiscipline($discipline);

            if ($athlete->getPhoto() === null) {
                $athlete->setPhoto($athlete->getOldPhoto());
            } else {
                $photo = $athlete->getPhoto();
                $photoName = md5(uniqid()). ".". $photo->guessExtension();
                
                $photo->move(
                    $this->getParameter("upload_profil"),
                    $photoName
                );
                $athlete->setPhoto($photoName);
                
                if (file_exists($this->getParameter("upload_profil") ."/". $athlete->getOldPhoto())) {
                    unlink($this->getParameter("upload_profil") ."/". $athlete->getOldPhoto());
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($athlete);
            $em->persist($oldDiscipline);
            $em->flush();

            return $this->redirectToRoute("athletes");
        }

        return $this->render("athlete/update.html.twig",[
            'form' => $form->createView(),
            'athlete' => $athlete
        ]);
    }

    /**
     * @Route("/{id}/delete", name="deleteAthlete")
     */
    public function delete(Athlete $athlete)
    {
        $discipline = $athlete->getDiscipline();
        $nbCandidats = $discipline->getNombreCandidats() -1;
        $discipline->setNombreCandidats($nbCandidats);

        $em = $this->getDoctrine()->getManager();
        $em->remove($athlete);
        $em->persist($discipline);
        $em->flush();

        return $this->redirectToRoute("athletes");
    }
}
