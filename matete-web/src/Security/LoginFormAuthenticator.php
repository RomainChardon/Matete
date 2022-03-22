<?php

namespace App\Security;

use App\Repository\ProducteurRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

class LoginFormAuthenticator extends AbstractAuthenticator
{
    private $producteurRepository;

    public function __construct(ProducteurRepository $producteurRepository)
    {
        $this->producteurRepository = $producteurRepository;
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'login_security'
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $producteur = $this->producteurRepository->findOneByMail($request->request->get('mail'));

        if (!$producteur) {
            
            throw new CustomUserMessageAuthenticationException('Username non valide');
        }

        return new Passport( new UserBadge($request->request->get('mail')), 
        new PasswordCredentials($request->request->get('pass')), [
            new CsrfTokenBadge('log_form', $request->request->get('csrf_token'))
        ]);
    }

    /*
    * phpcs:disable
    */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response // phpcs:disable
    {
        return new RedirectResponse('/');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response // phpcs:disable
    {
        return new RedirectResponse('/login');
    }
}