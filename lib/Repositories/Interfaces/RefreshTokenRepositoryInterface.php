<?php

namespace SimpleSAML\Modules\OpenIDConnect\Repositories\Interfaces;

use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface as OAuth2RefreshTokenRepositoryInterface;
use SimpleSAML\Modules\OpenIDConnect\Entity\Interfaces\RefreshTokenEntityInterface;

interface RefreshTokenRepositoryInterface extends OAuth2RefreshTokenRepositoryInterface
{
    /**
     * Revoke refresh token(s) associated with the given auth code ID.
     * @param string $authCodeId
     */
    public function revokeByAuthCodeId(string $authCodeId): void;

    /**
     * Creates a new refresh token
     *
     * @return RefreshTokenEntityInterface|null
     */
    public function getNewRefreshToken();
}
