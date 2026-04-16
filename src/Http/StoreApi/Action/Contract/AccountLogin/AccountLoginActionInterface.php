<?php

declare(strict_types=1);

namespace Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\Action\Contract\AccountLogin;

use Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\ErrorHandling\Exception\CustomerAuthBadCredentialsException;

interface AccountLoginActionInterface
{
    /**
     * @throws CustomerAuthBadCredentialsException
     */
    public function login(AccountLoginCredentials $credentials): string;
}
