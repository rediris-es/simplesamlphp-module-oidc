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
use SimpleSAML\Modules\OpenIDConnect\ClaimTranslatorExtractor;
use SimpleSAML\Modules\OpenIDConnect\Services\ConfigurationService;
use SimpleSAML\Modules\OpenIDConnect\Services\IdTokenBuilder;

class IdTokenBuilderFactory
{
    /**
     * @var \SimpleSAML\Modules\OpenIDConnect\Services\ConfigurationService
     */
    private $configurationService;

    /**
     * @var \SimpleSAML\Modules\OpenIDConnect\ClaimTranslatorExtractor
     */
    private $claimTranslatorExtractor;
    /**
     * @var CryptKey
     */
    private $privateKey;


    public function __construct(
        ConfigurationService $configurationService,
        ClaimTranslatorExtractor $claimTranslatorExtractor,
        CryptKey $privateKey
    ) {
        $this->configurationService = $configurationService;
        $this->claimTranslatorExtractor = $claimTranslatorExtractor;
        $this->privateKey = $privateKey;
    }

    public function build(): IdTokenBuilder
    {
        return new IdTokenBuilder(
            $this->claimTranslatorExtractor,
            $this->configurationService,
            $this->privateKey
        );
    }
}
