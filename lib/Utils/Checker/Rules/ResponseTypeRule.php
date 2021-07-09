<?php

namespace SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Rules;

use Psr\Http\Message\ServerRequestInterface;
use SimpleSAML\Modules\OpenIDConnect\Server\Exceptions\OidcServerException;
use SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Interfaces\ResultBagInterface;
use SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Interfaces\ResultInterface;
use SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Result;

class ResponseTypeRule extends AbstractRule
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
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['response_type']) || !isset($queryParams['client_id'])) {
            throw  OidcServerException::invalidRequest('Missing response_type');
        }

        // TODO consider checking for supported response types, for example, from configuration...

        return new Result($this->getKey(), $queryParams['response_type']);
    }
}
