<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\service;
use UserBundle\Form\serviceType;
use UserBundle\Repository\ReclamationRepository;
use UserBundle\Entity\Reclamation;

class DefaultController extends Controller
{
    public function indexAction()
    {


        if (is_object($this->getUser())) {
            foreach ($this->getUser()->getRoles() as $item) {
                if ($item == "ROLE_SUPER_ADMIN") {
                    return $this->render('UserBundle:Default:Dashboard.html.twig');
                }
            }
        }

        $m = $this->getDoctrine()->getManager();
        $departements = $m->getRepository('UserBundle:departement')->findAll();

        return $this->render('UserBundle::layout.html.twig',
            array(
                'departements' => $departements,
            )
        );



    }

    public function dashboardAction()
    {


        $em=$this->getDoctrine()->getManager();
        $c=$em->getRepository("UserBundle:reclamation")->nbrReclamation();

        return $this->render('UserBundle:Default:Dashboard.html.twig',array('cpt'=>$c));
    }

    public function departementsAction()
    {
        return $this->render('UserBundle:Default:Departements.html.twig');
    }

    public function evenementsAction()
    {
        return $this->render('UserBundle:Default:Evenements.html.twig');
    }

    public function forumAction()
    {
        return $this->render('UserBundle:Default:Forum.html.twig');
    }

    public function reclamationsAction()
    {
        return $this->render('UserBundle:Default:Reclamations.html.twig');
    }

    public function contactsAction()
    {
        return $this->render('UserBundle:Default:Contacts.html.twig');
    }

}