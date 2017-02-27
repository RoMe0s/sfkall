<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Page;
use AdminBundle\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{

    protected $module = 'page';

    public function indexAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Page::class);

        $data = $repository->getFullList(
            'page',
            $request->getLocale()
        );

        $tb = $this->get('tables_builder');

        $translator = $this->get('translator');

        $list = $tb
        ->of($data, array('slug', 'title', 'template'))
        ->edit('title', function($model) use ($translator) {
              return $model->getTitle() === null ? $translator->trans('no') : $model->getTitle();
        })
        ->edit('template', function ($model) use ($translator) {
            return $model->getTemplate() ? $model->getTemplate : $translator->trans('no');
        })
        ->add('actions', function ($model) {
            return $this->renderView('AdminBundle:datatables:controls.html.twig',
                array(
                    'module' => $this->module,
                    'model' => $model,
                    'link' => true
                )
            );
        })
        ->make();

        return $this->render('AdminBundle:page:index.html.twig', array(
            'list' => $list
        ));
    }

    public function editAction($id)
    {
        return $this->render('AdminBundle:page:edit.html.twig', array(
            // ...
        ));
    }

    public function createAction(Request $request)
    {

        $page = new Page();

        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);

//        dump($page); die;

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($page);

            $em->flush();

            return $this->redirectToRoute('pages');

        }

        return $this->render('AdminBundle:page:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function storeAction(Request $request)
    {
//        $page = new Page();

        dump($request->request->all()); die;

        dump($page); die;

        $validator = $this->get('validator');

        $errors = $validator->validate($page);

        dump($errors); die;

        return $this->render('AdminBundle:page:create.html.twig', array(
            // ...
        ));
    }


}
