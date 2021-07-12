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

namespace SimpleSAML\Modules\OpenIDConnect\Factories;

use League\OAuth2\Server\CryptKey;
use SimpleSAML\Modules\OpenIDConnect\Repositories\UserRepository;
use SimpleSAML\Modules\OpenIDConnect\Server\ResponseTypes\IdTokenResponse;
use SimpleSAML\Modules\OpenIDConnect\Services\ConfigurationService;
use SimpleSAML\Modules\OpenIDConnect\Services\IdTokenBuilder;

class IdTokenResponseFactory
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ConfigurationService
     */
    private $configurationService;
    /**
     * @var IdTokenBuilder
     */
    private $idTokenBuilder;
    /**
     * @var CryptKey
     */
    private $privateKey;
    /**
     * @var string
     */
    private $encryptionKey;

    public function __construct(
        UserRepository $userRepository,
        ConfigurationService $configurationService,
        IdTokenBuilder $idTokenBuilder,
        CryptKey $privateKey,
        string $encryptionKey
    ) {
        $this->userRepository = $userRepository;
        $this->configurationService = $configurationService;
        $this->idTokenBuilder = $idTokenBuilder;
        $this->privateKey = $privateKey;
        $this->encryptionKey = $encryptionKey;
    }

    public function build(): IdTokenResponse
    {
        $idTokenResponse = new IdTokenResponse(
            $this->userRepository,
            $this->configurationService,
            $this->idTokenBuilder
        );
        $idTokenResponse->setPrivateKey($this->privateKey);
        $idTokenResponse->setEncryptionKey($this->encryptionKey);

        return $idTokenResponse;
    }
}
