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

namespace SimpleSAML\Modules\OpenIDConnect\Controller;

use SimpleSAML\Modules\OpenIDConnect\Controller\Traits\GetClientFromRequestTrait;
use SimpleSAML\Modules\OpenIDConnect\Entity\ClientEntity;
use SimpleSAML\Modules\OpenIDConnect\Factories\FormFactory;
use SimpleSAML\Modules\OpenIDConnect\Factories\TemplateFactory;
use SimpleSAML\Modules\OpenIDConnect\Form\ClientForm;
use SimpleSAML\Modules\OpenIDConnect\Repositories\ClientRepository;
use SimpleSAML\Modules\OpenIDConnect\Services\ConfigurationService;
use SimpleSAML\Modules\OpenIDConnect\Services\SessionMessagesService;
use SimpleSAML\Utils\HTTP;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;

class ClientEditController
{
    use GetClientFromRequestTrait;

    /**
     * @var ConfigurationService
     */
    private $configurationService;

    /**
     * @var TemplateFactory
     */
    private $templateFactory;
    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var SessionMessagesService
     */
    private $messages;

    public function __construct(
        ConfigurationService $configurationService,
        ClientRepository $clientRepository,
        TemplateFactory $templateFactory,
        FormFactory $formFactory,
        SessionMessagesService $messages
    ) {
        $this->configurationService = $configurationService;
        $this->clientRepository = $clientRepository;
        $this->templateFactory = $templateFactory;
        $this->formFactory = $formFactory;
        $this->messages = $messages;
    }

    /**
     * @return \Laminas\Diactoros\Response\RedirectResponse|\SimpleSAML\XHTML\Template
     */
    public function __invoke(ServerRequest $request)
    {
        $client = $this->getClientFromRequest($request);

        $form = $this->formFactory->build(ClientForm::class);
        $formAction = sprintf(
            "%s/clients/edit.php?client_id=%s",
            $this->configurationService->getOpenIdConnectModuleURL(),
            $client->getIdentifier()
        ) ;
        $form->setAction($formAction);
        $form->setDefaults($client->toArray());

        if ($form->isSuccess()) {
            $data = $form->getValues();

            $this->clientRepository->update(ClientEntity::fromData(
                $client->getIdentifier(),
                $client->getSecret(),
                $data['name'],
                $data['description'],
                $data['auth_source'],
                $data['redirect_uri'],
                $data['scopes'],
                (bool) $data['is_enabled'],
                (bool) $data['is_confidential']
            ));

            $this->messages->addMessage('{oidc:client:updated}');

            return new RedirectResponse(HTTP::addURLParameters('show.php', ['client_id' => $client->getIdentifier()]));
        }

        return $this->templateFactory->render('oidc:clients/edit.twig', [
            'form' => $form,
        ]);
    }
}
