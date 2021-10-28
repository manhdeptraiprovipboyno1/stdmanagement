<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct (SessionInterface $session, RouterInterface $router){
        $this->session = $session;
        $this->router = $router;
    }

    public function handle (Request $request, AccessDeniedException $exception){
        // trả về thông báo lỗi
        $this->session->getFlashBag()->add('Error','Unauthorized Access');
        // redirect về login
        return new RedirectResponse($this->router->generate('app_login'));
    }
}
?>