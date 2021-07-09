<?php

namespace SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Rules;

use Psr\Http\Message\ServerRequestInterface;
use SimpleSAML\Modules\OpenIDConnect\Server\Exceptions\OidcServerException;
use SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Interfaces\ResultBagInterface;
use SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Interfaces\ResultInterface;
use SimpleSAML\Modules\OpenIDConnect\Utils\Checker\Result;

class CodeChallengeRule extends AbstractRule
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
        /** @var string $redirectUri */
        $redirectUri = $currentResultBag->getOrFail(RedirectUriRule::class)->getValue();
        /** @var string|null $state */
        $state = $currentResultBag->getOrFail(StateRule::class)->getValue();

        $codeChallenge = $request->getQueryParams()['code_challenge'] ?? null;

        if ($codeChallenge === null) {
            throw OidcServerException::invalidRequest(
                'code_challenge',
                'Code challenge must be provided for public clients',
                null,
                $redirectUri,
                $state,
                $useFragmentInHttpErrorResponses
            );
        }

        // Validate code_challenge according to RFC-7636
        // @see: https://tools.ietf.org/html/rfc7636#section-4.2
        if (\preg_match('/^[A-Za-z0-9-._~]{43,128}$/', $codeChallenge) !== 1) {
            throw OidcServerException::invalidRequest(
                'code_challenge',
                'Code challenge must follow the specifications of RFC-7636.',
                null,
                $redirectUri,
                $state,
                $useFragmentInHttpErrorResponses
            );
        }

        return new Result($this->getKey(), $codeChallenge);
    }
}
