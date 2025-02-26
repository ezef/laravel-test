<?php

declare(strict_types=1);

namespace Lightit\Authentication\Domain\Actions;

use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Lightit\Backoffice\Users\Domain\Models\User;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

class LogoutAction
{
    public function __construct(
        private readonly AuthFactory $factory,
    ) {
    }

    public function execute(User $user): void
    {
        /** @var JWTGuard $guard */
        $guard = $this->factory->guard();
        $guard->logout();

        $user->clearTwoFactorAuthenticationCredentials();
    }
}
