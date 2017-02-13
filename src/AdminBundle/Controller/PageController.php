<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{

    protected $module = 'page';

    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Page::class);

        $data = $repository->getFullList(
            'page',
            $request->getLocale(), array('page.id', 'translation.title', 'page.slug', 'page.template')
        );

        $tb = $this->get('tables_builder');

        $translator = $this->get('translator');

        $list = $tb
        ->of($data)
        ->edit('template', function ($model) use ($translator) {
            return $model['template'] ? $model['template'] : $translator->trans('no');
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

        $form = $this->createFormBuilder($page)
            ->add('slug', TextType::class)
            ->add('apply', SubmitType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            dump($form->isValid()); die;

        }

        return $this->render('AdminBundle:page:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function storeAction(Request $request)
    {
        $page = new Page();

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
