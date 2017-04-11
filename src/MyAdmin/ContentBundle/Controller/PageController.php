<?php

namespace MyAdmin\ContentBundle\Controller;

use MyAdmin\AdminBundle\Classes\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 * @package MyAdmin\ContentBundle\Controller
 */
class PageController extends AbstractController
{

    /**
     * @var string
     */
    protected $module = 'page';

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository($this->entityName); //get repository

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
            })
            ->make(); //build custom table

        return $this->render($this->_bundle . ':' . $this->module . ':index.html.twig', array(
            'list' => $list
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function editAction(int $id, Request $request)
    {

        $repository = $this->getDoctrine()->getRepository($this->entityName); //get repository

        $entity = $repository->findWithTranslations($id);

        return $this->_callSaver($entity, $request);

    }


}