<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Page;
use AdminBundle\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Traits\Controller\RequestHandlerTrait;

class PageController extends Controller
{

    use RequestHandlerTrait;

    protected $module = 'page';

    public function indexAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Page::class); //get repository

        $data = $repository->getFullList($request->getLocale()); //get data with translations

        $tb = $this->get('TablesBuilder'); //init tables builder

        $translator = $this->get('translator'); //init translator

        $list = $tb
        ->of($data, array('id', 'slug', 'title', 'template', 'status'), $request->getLocale())
            ->edit('title', function($model) use ($translator) {
                  return !$model->getTitle() ? $translator->trans('no') : $model->getTitle();
            })
            ->edit('template', function ($model) use ($translator) {
                return $model->getTemplate() ? $model->getTemplate() : $translator->trans('no');
            })
            ->edit('status', function($model) use ($translator) {
                return $model->getStatus() === FALSE ? $translator->trans('no') : $translator->trans('yes');
            })
            ->add('actions', function ($model) {
                return $this->renderView('AdminBundle:datatables:controls.html.twig',
                    array(
                        'module' => $this->module,
                        'model' => $model,
                        'link' => true
                    )
                );
            })->make(); //build custom table

        return $this->render('AdminBundle:' . $this->module . ':index.html.twig', array(
            'list' => $list
        ));
    }

    public function editAction($id, Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Page::class); //get repository

        $page = $repository->findWithTranslations($id);

        return $this->_callSaveRequestHandler($page, $request);

    }

    public function createAction(Request $request)
    {
        $page = new Page();

        return $this->_callSaveRequestHandler($page, $request);

    }

    private function _callSaveRequestHandler(Page $page, Request $request) {

        $form = $this->createForm(PageType::class, $page, array(
            'templates' => array('In Stock' => 'In Stock', 'Out of Stock' => 'Out of Stock'),
            'parents' => array()
        )); //TODO: get by folder

        return $this->handleSaveRequest($form, $request, $page);

    }


}