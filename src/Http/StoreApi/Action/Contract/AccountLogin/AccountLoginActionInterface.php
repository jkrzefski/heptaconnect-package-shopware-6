<?php

declare(strict_types=1);

namespace Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\Action\Contract\AccountLogin;

interface AccountLoginActionInterface
{
    public function login(AccountLoginCredentials $credentials): string;
}
