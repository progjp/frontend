<?php

// src/Security/Firewall/WsseListener.php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticatorManagerInterface;

class UserListener
{
    protected $tokenStorage;
    protected $authenticationManager;

    public function __construct(TokenStorageInterface $tokenStorage, AuthenticatorManagerInterface $authenticationManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $wsseRegex = '/UsernameToken Username="(?P<username>[^"]+)", PasswordDigest="(?P<digest>[^"]+)", Nonce="(?P<nonce>[a-zA-Z0-9+\/]+={0,2})", Created="(?P<created>[^"]+)"/';
        if (!$request->headers->has('x-wsse') || 1 !== preg_match($wsseRegex, $request->headers->get('x-wsse'), $matches)) {
            return;
        }

        $token = new UserToken();
        $token->setUser($matches['username']);

        $token->digest  = $matches['digest'];
        $token->created = $matches['created'];

        try {
            $this->tokenStorage->setToken(new UserToken());

            return;
        } catch (AuthenticationException $failed) {
            // ... you might log something here

            // To deny the authentication, clear the token. This will redirect to the login page.
            // Make sure to only clear your token, not those of other authentication listeners.
            // $token = $this->tokenStorage->getToken();
            // if ($token instanceof WsseUserToken && $this->providerKey === $token->getProviderKey()) {
            //     $this->tokenStorage->setToken(null);
            // }
            // return;
        }

        // By default deny authorization
        $response = new Response();
        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        $event->setResponse($response);
    }
}