<?php

namespace ReclamationBundle\Controller;
use ReclamationBundle;
use UserBundle\Entity\reclamation;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class GrapheController extends Controller
{
    public function indexAction()
    {

        $em= $this->getDoctrine();
        $reclamation1 = $em->getRepository('UserBundle:reclamation')->findByService('1');
        $cat= array();
        $v=0;
        foreach ($reclamation1 as $prod)
        {
            array_push($cat, $prod);
            $v=$v+1;
        }
        $reclamation2 = $em->getRepository('UserBundle:reclamation')->findByService('2');
        $cat2= array();
        $c=0;
        foreach ($reclamation2  as $prod2)
        {
            array_push($cat2, $prod2);
            $c=$c+1;
        }

        $reclamation3 = $em->getRepository('UserBundle:reclamation')->findByService('3');
        $cat3= array();
        $t=0;
        foreach ($reclamation3 as $prod3)
        {
            array_push($cat3, $prod3);
            $t=$t+1;
        }






        $pieChart = new PieChart();
$pieChart->getData()->setArrayToDataTable(
  [
      ['service','nombres deservice'],
      ['yoga',$v],
      ['radiologie',$c],
      ['pédiatrie',$t],
  ]
);

        $pieChart->getOptions()->setTitle('Pourcentage du Reclamation par service');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


// nombre de reclamation non lu cpt :
        $em=$this->getDoctrine()->getManager();
        $c=$em->getRepository("UserBundle:reclamation")->nbrReclamation();
//
        return $this->render('ReclamationBundle:Reclamation:graphe.html.twig',
            array(
            'piechart' => $pieChart,
                'cpt'=>$c,



        ));
    }








}
