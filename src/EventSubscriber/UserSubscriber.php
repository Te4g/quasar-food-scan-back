<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

final class UserSubscriber implements EventSubscriberInterface
{
    private $tokenStorage;
    private $userPasswordEncoder;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        UserPasswordEncoderInterface $userPasswordEncoder
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['resolveMe', EventPriorities::PRE_READ],
            ],
            KernelEvents::VIEW => ['encodePassword', EventPriorities::POST_VALIDATE],
        ];
    }

    public function resolveMe(RequestEvent $event)
    {
        $request = $event->getRequest();
        dd($request);

        if ('api_users_get_item' !== $request->attributes->get('_route')) {
            return;
        }

        if ('me' !== $request->attributes->get('id')) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();

        if (!$user instanceof User) {
            return;
        }

        $request->attributes->set('id', $user->getId());
    }

    public function encodePassword(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (
            !$user instanceof User
            || !in_array($method, [Request::METHOD_POST, Request::METHOD_PUT], true)
        ) {
            return;
        }

        $encoder = new JsonEncoder();
        $data = $encoder->decode((string)$event->getRequest()->getContent(), 'json');

        if (!isset($data['password'])) {
            return;
        }

        $user->setPassword($this->userPasswordEncoder->encodePassword(new User(), $data['password']));
    }
}
