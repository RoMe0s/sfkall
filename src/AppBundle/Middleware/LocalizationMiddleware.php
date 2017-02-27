<?php
namespace AppBundle\Middleware;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LocalizationMiddleware {

        /**
         * @var null|Container
         */
        protected $container = null;

        /**
         * @var null|Router
         */
        protected $router = null;

        function __construct(Container $container, UrlGeneratorInterface $router) {
            $this->container = $container;
            $this->router = $router;
        }

        public function onKernelController($event)
		{
            $defaultLocale = $this->container->getParameter('jms_i18n_routing.default_locale');
            $baseUrl = $event->getRequest()->getPathInfo();
            $firstPart = array_values(array_filter(explode('/', $baseUrl)));
            $uri = isset($firstPart[0]) ? $firstPart[0] : null;
            if($uri != 'admin') {
                if($uri == $defaultLocale) {
                    $url = $this->router->generate('homepage');
                    $event->setController(function() use ($url) {
                       return new RedirectResponse($url, 301);
                    });
                }
            }
		}
}