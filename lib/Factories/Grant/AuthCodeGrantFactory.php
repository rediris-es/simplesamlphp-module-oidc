<?php

/*
 * This file is part of the simplesamlphp-module-oidc.
 *
 * Copyright (C) 2018 by the Spanish Research and Academic Network.
 *
 * This code was developed by Universidad de Córdoba (UCO https://www.uco.es)
 * for the RedIRIS SIR service (SIR: http://www.rediris.es/sir)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleSAML\Module\oidc\Factories\Grant;

use SimpleSAML\Module\oidc\Server\Grants\AuthCodeGrant;
use SimpleSAML\Module\oidc\Repositories\AuthCodeRepository;
use SimpleSAML\Module\oidc\Repositories\RefreshTokenRepository;
use SimpleSAML\Module\oidc\Utils\Checker\RequestRulesManager;

class AuthCodeGrantFactory
{
    /**
     * @var \SimpleSAML\Module\oidc\Repositories\AuthCodeRepository
     */
    private $authCodeRepository;

    /**
     * @var \SimpleSAML\Module\oidc\Repositories\RefreshTokenRepository
     */
    private $refreshTokenRepository;

    /**
     * @var \DateInterval
     */
    private $refreshTokenDuration;

    /**
     * @var \DateInterval
     */
    private $authCodeDuration;
    /**
     * @var RequestRulesManager
     */
    private $requestRulesManager;

    public function __construct(
        AuthCodeRepository $authCodeRepository,
        RefreshTokenRepository $refreshTokenRepository,
        \DateInterval $refreshTokenDuration,
        \DateInterval $authCodeDuration,
        RequestRulesManager $requestRulesManager
    ) {
        $this->authCodeRepository = $authCodeRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
        $this->refreshTokenDuration = $refreshTokenDuration;
        $this->authCodeDuration = $authCodeDuration;
        $this->requestRulesManager = $requestRulesManager;
    }

    public function build(): AuthCodeGrant
    {
        $authCodeGrant = new AuthCodeGrant(
            $this->authCodeRepository,
            $this->refreshTokenRepository,
            $this->authCodeDuration,
            $this->requestRulesManager
        );
        $authCodeGrant->setRefreshTokenTTL($this->refreshTokenDuration);

        return $authCodeGrant;
    }
}
