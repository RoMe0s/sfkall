<?php

namespace MyAdmin\ContentBundle\Controller;

use MyAdmin\AdminBundle\Classes\AdminAbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 * @package MyAdmin\ContentBundle\Controller
 */
class PageController extends AdminAbstractController
{

    /**
     * @var string
     */
    protected $module = 'page';

    public function _fillIndexData(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository($this->entityName); //get repository

        $data = $repository->getFullListWithTranslations($request->getLocale()); //get data with translations

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

        $this->passData('list', $list);
    }

    public function _fillFormType(Request $request, $model)
    {

        $data = [
            'templates' => [
                '1',
                '2',
                '3'
            ]
        ];

        return $data;

    }

}