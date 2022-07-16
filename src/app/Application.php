<?php

namespace Capangas\Touchfic\app;

/**
 * Classe da aplicação
*/
class Application
{

    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function send()
    {
        $this->router->send();
    }
}
