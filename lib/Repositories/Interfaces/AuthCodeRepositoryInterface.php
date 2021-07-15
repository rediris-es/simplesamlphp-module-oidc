<?php

namespace SimpleSAML\Modules\OpenIDConnect\Repositories\Interfaces;

use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface as OAuth2AuthCodeRepositoryInterface;
use SimpleSAML\Modules\OpenIDConnect\Entity\Interfaces\AuthCodeEntityInterface;

interface AuthCodeRepositoryInterface extends OAuth2AuthCodeRepositoryInterface
{
    /**
     * Creates a new AuthCode
     *
     * @return AuthCodeEntityInterface
     */
    public function getNewAuthCode(): AuthCodeEntityInterface;
}
