<?php

declare(strict_types=1);

namespace Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\Action;

use Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\Action\Contract\AccountLogin\AccountLoginActionInterface;
use Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\Action\Contract\AccountLogin\AccountLoginCredentials;
use Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\ErrorHandling\Exception\CustomerAuthBadCredentialsException;

final class AccountLoginAction extends AbstractActionClient implements AccountLoginActionInterface
{
    public function login(AccountLoginCredentials $credentials): string
    {
        $request = $this->generateRequest('POST', 'account/login', [], [
            'username' => $credentials->getUsername(),
            'password' => $credentials->getPassword(),
        ]);

        $response = $this->sendAuthenticatedRequest($request);

        if ($response->getStatusCode() === 200) {
            $contextToken = $response->getHeaderLine('sw-context-token');

            if ($contextToken === '') {
                throw new CustomerAuthBadCredentialsException(
                    $request,
                    $response,
                    'Missing sw-context-token in response',
                    1776258143,
                );
            }

            return $contextToken;
        }

        try {
            $responseData = \json_decode(
                (string) $response->getBody(),
                true,
                flags: \JSON_THROW_ON_ERROR,
            );
        } catch (\JsonException) {
            throw new CustomerAuthBadCredentialsException(
                $request,
                $response,
                'Response body is malformed',
                1776337962,
            );
        }

        $errors = $responseData['errors'] ?? [];

        if ($errors === [] || !\is_array($errors)) {
            throw new CustomerAuthBadCredentialsException(
                $request,
                $response,
                'Response body is missing errors',
                1776338023,
                new \Exception((string) $response->getBody(), $response->getStatusCode()),
            );
        }

        $error = $errors[0];

        throw new CustomerAuthBadCredentialsException(
            $request,
            $response,
            (string) $error['detail'],
            (int) $error['status'],
        );
    }
}
