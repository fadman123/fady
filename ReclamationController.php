<?php

namespace ReclamationBundle\Controller;
use ReclamationBundle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Validator\Constraints\Count;
use UserBundle\Entity\reclamation;
use UserBundle\Entity\service;
class ReclamationController extends Controller

{

   public function ListAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository("UserBundle:reclamation")->findAll();

        return $this->render('ReclamationBundle:Reclamation:affRec.html.twig',array("Reclamations"=>$reclamation));
    }


    public function indexAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $service = $m->getRepository('UserBundle:service')->findAll();

        return $this->render('UserBundle:Default:Reclamations.html.twig',array(
            'services'=>$service
        ));
    }


    public function index1Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository("UserBundle:reclamation")->nbrReclamation();

        $m = $this->getDoctrine()->getManager();
        $service = $m->getRepository('UserBundle:service')->findAll();
        $reclamation = $m->getRepository('UserBundle:reclamation')->findAll();


        $tabserv = array();
        $con = $em->getConnection();
        foreach ($reclamation as $rec) {
            $r = $rec->getService()->getId();
            $nomserv = $rec->getService()->getNom();
            //  var_dump($r);
            $sql = "SELECT COUNT(*) titre  FROM reclamation WHERE service_id=" . $r;
            $nbrec = $con->query($sql)->fetch();
            // var_dump($req["titre"]);die();
            if ($nbrec["titre"] >= 5 && !in_array($nomserv, $tabserv)) {

                array_push($tabserv, $nomserv);


            }

        }

        return $this->render('ReclamationBundle:reclamation:index.html.twig',
            array(
                'reclamation' => $reclamation,
                'services' => $service,
                'cpt' => $c,
                'servicereclame' => $tabserv,


            )
        );


    }


    public function reclamationAction(Request $request)
    {


        $rech=$request->get('titre');



        $em=$this->getDoctrine()->getManager();
        $c=$em->getRepository("UserBundle:reclamation")->nbrReclamation();

        $m = $this->getDoctrine()->getManager();
        $service = $m->getRepository('UserBundle:service')->findAll();
        $reclamation = $m->getRepository('UserBundle:reclamation')->findAll();


        $tabserv= array();
        $con= $em->getConnection();
        foreach ($reclamation as $rec)
        {
           $r= $rec->getService()->getId();
            $nomserv= $rec->getService()->getNom();
          //  var_dump($r);
            $sql="SELECT COUNT(*) titre  FROM reclamation WHERE service_id=".$r;
            $nbrec=$con->query($sql)->fetch();
           // var_dump($req["titre"]);die();
            if($nbrec["titre"]>=5 && ! in_array($nomserv,$tabserv))

            {

                array_push($tabserv,$nomserv);


            }

        }
       //var_dump($tabserv);die();
        //recherche
        if($request->getMethod()=="POST"){

            $reclamation = $em->getRepository('UserBundle:reclamation')->findtitreDQL($rech);



            return $this->render('ReclamationBundle:reclamation:gestionReclamation.html.twig',
                array(
                    'reclamation' => $reclamation,
                    'services'=>$service,
                    'cpt'=>$c,
                    'servicereclame'=>$tabserv,


                )
            );
        }


        return $this->render('ReclamationBundle:reclamation:gestionReclamation.html.twig',
            array(
                'reclamation' => $reclamation,
                'services'=>$service,
                'cpt'=>$c,
                'servicereclame'=>$tabserv,


            )
        );
    }

    public function reclamaAction()
    {
        $m = $this->getDoctrine()->getManager();
        $service = $m->getRepository('UserBundle:service')->findAll();
        $reclamation = $m->getRepository('UserBundle:reclamation')->findAll();
        return $this->render('ReclamationBundle:reclamation:gestionReclamation.html.twig',
            array(
                'reclamation' => $reclamation,
                'services'=>$service
            )
        );
    }







    public function DeleteAction ($id)

{
    $em=$this->getDoctrine()->getManager();
    $reclamation=$em->getRepository("UserBundle:reclamation")->find($id);
    $em->remove($reclamation);
    $em->flush();

    return $this->redirectToRoute('AfficheReclamation');
}



    public function Delete1Action ($id)

    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository("UserBundle:reclamation")->find($id);
        $em->remove($reclamation);
        $em->flush();


        return $this->redirectToRoute('reclamation');
    }

    public function UpdateAction (Request $request , $id)
    {

        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository("UserBundle:reclamation")->find($id);


        $Form = $this->createForm(ReclamationBundle\Form\reclamationType::class, $reclamation);
        $Form->handleRequest($request);

        if ($Form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();

            return $this->redirectToRoute('AfficheReclamation');
        }

        return $this->render('ReclamationBundle:Reclamation:updaterec.html.twig', array('form' => $Form->createView()));

    }





    public  function Ajout3Action (Request $request)
    {
        $reclamation=new Reclamation();

        $Form=$this->createForm(ReclamationBundle\Form\reclamationType::class , $reclamation);
        $Form->handleRequest($request);

        if($Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $reclamation->UploadProfilePicture();


            $em->persist($reclamation);
            $em->flush();

            return $this->redirectToRoute('AfficheReclamation');
        }

        return $this->render('ReclamationBundle:Reclamation:Reclamations.html.twig',array('form'=>$Form->createView()));

    }










}
