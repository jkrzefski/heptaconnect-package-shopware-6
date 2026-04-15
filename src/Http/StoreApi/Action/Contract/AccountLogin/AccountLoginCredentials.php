<?php

declare(strict_types=1);

namespace Heptacom\HeptaConnect\Package\Shopware6\Http\StoreApi\Action\Contract\AccountLogin;

use Heptacom\HeptaConnect\Dataset\Base\AttachmentCollection;
use Heptacom\HeptaConnect\Dataset\Base\Contract\AttachmentAwareInterface;
use Heptacom\HeptaConnect\Dataset\Base\Support\AttachmentAwareTrait;

final class AccountLoginCredentials implements AttachmentAwareInterface
{
    use AttachmentAwareTrait;

    public function __construct(
        private string $username,
        private string $password,
    ) {
        $this->attachments = new AttachmentCollection();
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function withUsername(string $username): self
    {
        $that = clone $this;
        $that->username = $username;

        return $that;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function withPassword(string $password): self
    {
        $that = clone $this;
        $that->password = $password;

        return $that;
    }
}
