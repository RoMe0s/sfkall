<?php

/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 19.03.17
 * Time: 20:38
 */
namespace WidgetBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class ViewListener
{

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * ViewListener constructor.
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {

        $this->templating = $templating;

    }

    public function onKernelView(GetResponseForControllerResultEvent $event) {

        die('here');

        $val = $event->getControllerResult();

        dump($val);

        die;

    }

}