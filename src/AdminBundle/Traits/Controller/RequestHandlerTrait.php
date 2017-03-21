<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 13.03.17
 * Time: 16:09
 */

namespace AdminBundle\Traits\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestHandlerTrait
 * @package AdminBundle\Traits\Controller
 */
trait RequestHandlerTrait
{

    public function handleSaveRequest(Form $form, Request $request, $model) {

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($model);

            $em->flush();

            return $this->redirectToRoute($this->module . '.index');

        }

        return $this->render('AdminBundle:' . $this->module . ':edit.html.twig', array(
            'form' => $form->createView(),
            'module' => $this->module
        ));

    }

}