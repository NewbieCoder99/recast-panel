<?php

namespace App\Component\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonListener implements EventSubscriberInterface
{
    /**
     * @return array
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'convertJsonStringToArray',
        ];
    }

    /**
     * @param FilterControllerEvent $event
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function convertJsonStringToArray(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        if ($request->getContentType() !== 'json' || !$request->getContent()) {
            return;
        }
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('invalid json body: ' . json_last_error_msg());
        }
        $request->request->replace(\is_array($data) ? $data : []);
    }
}