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

use SimpleSAML\Modules\OpenIDConnect\ClaimTranslatorExtractor;
use SimpleSAML\Modules\OpenIDConnect\Repositories\UserRepository;
use SimpleSAML\Modules\OpenIDConnect\Server\ResponseTypes\IdTokenResponse;
use SimpleSAML\Modules\OpenIDConnect\Services\ConfigurationService;

class IdTokenResponseFactory
{
    /**
     * @var \SimpleSAML\Modules\OpenIDConnect\Repositories\UserRepository
     */
    private $userRepository;

    /**
     * @var \SimpleSAML\Modules\OpenIDConnect\Services\ConfigurationService
     */
    private $configurationService;

    /**
     * @var \SimpleSAML\Modules\OpenIDConnect\ClaimTranslatorExtractor
     */
    private $claimTranslatorExtractor;

    public function __construct(
        UserRepository $userRepository,
        ConfigurationService $configurationService,
        ClaimTranslatorExtractor $claimTranslatorExtractor
    ) {
        $this->userRepository = $userRepository;
        $this->configurationService = $configurationService;
        $this->claimTranslatorExtractor = $claimTranslatorExtractor;
    }

    public function build(): IdTokenResponse
    {
        return new IdTokenResponse(
            $this->userRepository,
            $this->claimTranslatorExtractor,
            $this->configurationService
        );
    }
}
