<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelSubscriber implements EventSubscriberInterface {

	public function __construct($container)
	{
		$this->container = $container;
	}

	public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(
                array('onKernelRequest', 0)
            )
        );
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        // var_dump(array($event->getRequest()->getPathInfo() => preg_match('#^(\/admin\/)#', $event->getRequest()->getPathInfo())))

        if(preg_match('#^(\/admin\/|\/_|\/uploader\/)#', $event->getRequest()->getPathInfo()) && $event->getRequest()->getLocale() != 'pl')
        {
            $event->getRequest()->setLocale('pl');
            // $event->setResponse(new RedirectResponse($event->getRequest()->getUri()));
        }
        elseif($this->container->get('session')->get('defaultLocale'))
        {
            if($event->getRequest()->getLocale() != $this->container->get('session')->get('defaultLocale') && 'en' != $event->getRequest()->getLocale() )
            {
                $event->getRequest()->setLocale($this->container->get('session')->get('defaultLocale'));
            }
        }

    }

}