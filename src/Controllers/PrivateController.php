<?php

namespace Controllers;

abstract class PrivateController extends PublicController
{
    private function _isAuthorized()
    {
        $isAuthorized = \Utilities\Security::isAuthorized(
            \Utilities\Security::getUserId(),
            $this->name,
            'CTR'
        );
        if (!$isAuthorized) {
            throw new PrivateNoAuthException();
        }
    }

    private function _isAuthenticated()
    {
        if (!\Utilities\Security::isLogged()) {
            throw new PrivateNoLoggedException();
        }
    }

    protected function isFeatureAuthorized($feature): bool
    {
        return \Utilities\Security::isAuthorized(
            \Utilities\Security::getUserId(),
            $feature
        );
    }

    public function __construct()
    {
        parent::__construct();
        $this->_isAuthenticated();  // Verifica que el usuario esté autenticado
        $this->_isAuthorized();     // Verifica que el usuario tenga autorización
    }
}
