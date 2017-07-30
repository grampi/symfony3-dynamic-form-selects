<?php

namespace AppBundle\Controller;

use AppBundle\Form\CarType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SelectsController extends Controller {

    /**
     * @Route("/selects")
     */
    public function indexAction(Request $request) {
        $form = $this->createForm(CarType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            /*
              //return $this->redirectToRoute('task_success');
             */
        }

        return $this->render('default/selects.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

}
