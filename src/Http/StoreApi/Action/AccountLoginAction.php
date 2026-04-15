<?php

declare(strict_types=1);

namespace Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\Action;

use Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\Action\Contract\AccountLogin\AccountLoginActionInterface;
use Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\Action\Contract\AccountLogin\AccountLoginCredentials;

final class AccountLoginAction extends AbstractActionClient implements AccountLoginActionInterface
{
    public function login(AccountLoginCredentials $credentials): string
    {
        $request = $this->generateRequest('POST', 'account/login', [], [
            'username' => $credentials->getUsername(),
            'password' => $credentials->getPassword(),
        ]);

        $response = $this->sendAuthenticatedRequest($request);

        return $response->getHeaderLine('sw-context-token');
    }
}
