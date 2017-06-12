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

    /**
     * @param Request $request
     * @param array $fields
     */
    public function _fillIndexData(Request $request, array $fields = array())
    {

        parent::_fillIndexData($request, ['id', 'slug', 'title', 'template', 'status']);

    }

    /**
     * @param Request $request
     * @param $model
     * @return array
     */
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