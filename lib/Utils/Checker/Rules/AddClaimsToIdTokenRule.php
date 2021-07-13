<?php

namespace SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Rules;

use Psr\Http\Message\ServerRequestInterface;
use SimpleSAML\Modules\OpenIDConnect\Server\Exceptions\OidcServerException;
use SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Interfaces\ResultBagInterface;
use SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Interfaces\ResultInterface;
use SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Result;

class AddClaimsToIdTokenRule extends AbstractRule
{
    /**
     * @inheritDoc
     */
    public function checkRule(
        ServerRequestInterface $request,
        ResultBagInterface $currentResultBag,
        array $data = [],
        bool $useFragmentInHttpErrorResponses = false
    ): ?ResultInterface {

        $responseType = $currentResultBag->getOrFail(ResponseTypeRule::class)->getValue();

        return new Result($this->getKey(), $responseType === "id_token");
    }
}
