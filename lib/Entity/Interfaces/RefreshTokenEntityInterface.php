<?php

namespace SimpleSAML\Modules\OpenIDConnect\Entity\Interfaces;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface as OAuth2RefreshTokenEntityInterface;

interface RefreshTokenEntityInterface extends
    OAuth2RefreshTokenEntityInterface,
    TokenAssociatableWithAuthCodeInterface,
    TokenRevokableInterface,
    MementoInterface
{
}
