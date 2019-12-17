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

namespace SimpleSAML\Modules\OpenIDConnect\Repositories;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use SimpleSAML\Modules\OpenIDConnect\Entity\ClientEntity;

class ClientRepository extends AbstractDatabaseRepository implements ClientRepositoryInterface
{
    public const TABLE_NAME = 'oidc_client';


    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->database->applyPrefix(self::TABLE_NAME);
    }


    /**
     * @param string $clientIdentifier
     * @param string|null $grantType
     * @param string|null $clientSecret
     * @param bool $mustValidateSecret
     * @return \SimpleSAML\Modules\OpenIDConnect\Entity\ClientEntity|null
     */
    public function getClientEntity($clientIdentifier, $grantType = null, $clientSecret = null, $mustValidateSecret = true): ?ClientEntity
    {
        $client = $this->findById($clientIdentifier);

        if (!$client) {
            return null;
        }

        if (false === $client->isEnabled()) {
            return null;
        }

        return $client;
    }


    /**
     * @param string $clientIdentifier
     * @return \SimpleSAML\Modules\OpenIDConnect\Entity\ClientEntity|null
     */
    public function findById($clientIdentifier): ?ClientEntity
    {
        $stmt = $this->database->read(
            "SELECT * FROM {$this->getTableName()} WHERE id = :id",
            [
                'id' => $clientIdentifier,
            ]
        );

        if (!$rows = $stmt->fetchAll()) {
            return null;
        }

        return ClientEntity::fromState(current($rows));
    }


    /**
     * @return \SimpleSAML\Modules\OpenIDConnect\Entity\ClientEntity[]
     */
    public function findAll()
    {
        $stmt = $this->database->read(
            "SELECT * FROM {$this->getTableName()} ORDER BY name ASC"
        );

        $clients = [];

        foreach ($stmt->fetchAll() as $state) {
            $clients[] = ClientEntity::fromState($state);
        }

        return $clients;
    }


    /**
     * @param \SimpleSAML\Modules\OpenIDConnect\Entity\ClientEntity $client
     * @return void
     */
    public function add(ClientEntity $client): void
    {
        $this->database->write(
              "INSERT INTO {$this->getTableName()} (id, secret, name, description, auth_source, redirect_uri, scopes, is_enabled) VALUES (:id, :secret, :name, :description, :auth_source, :redirect_uri, :scopes, :is_enabled)",
            $client->getState()
        );
    }


    /**
     * @param \SimpleSAML\Modules\OpenIDConnect\Entity\ClientEntity $client
     * @return void
     */
    public function delete(ClientEntity $client): void
    {
        $this->database->write(
            "DELETE FROM {$this->getTableName()} WHERE id = :id",
            [
                'id' => $client->getIdentifier(),
            ]
        );
    }


    /**
     * @param \SimpleSAML\Modules\OpenIDConnect\Entity\ClientEntity $client
     * @return void
     */
    public function update(ClientEntity $client): void
    {
        $this->database->write(
            "UPDATE {$this->getTableName()} SET secret = :secret, name = :name, description = :description, auth_source = :auth_source, redirect_uri = :redirect_uri, scopes = :scopes, is_enabled = :is_enabled WHERE id = :id",
            $client->getState()
        );
    }
}
