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

class TemplateFactory
{
    /**
     * @var \SimpleSAML\Configuration
     */
    private $configuration;

    public function __construct(\SimpleSAML\Configuration $configuration)
    {
        $config = $configuration->toArray();
        $config['usenewui'] = true;

        $this->configuration = new \SimpleSAML\Configuration($config, 'oidc');
    }

    public function render(string $templateName, array $data = []): \SimpleSAML\XHTML\Template
    {
        $template = new \SimpleSAML\XHTML\Template($this->configuration, $templateName);
        $template->data += $data;

        return $template;
    }
}
