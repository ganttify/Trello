<?php

namespace SocialiteProviders\Trello;

use SocialiteProviders\Manager\OAuth1\AbstractProvider;
use SocialiteProviders\Manager\OAuth1\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'TRELLO';

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        if (!$this->hasNecessaryVerifier()) {
            throw new \InvalidArgumentException('Invalid request. Missing OAuth verifier.');
        }

        $token = $this->getToken();
        $this->server->setAccessToken($token->getIdentifier());
        $user = $this->server->getUserDetails($token);

        return (new User())->setRaw($user->extra)->map([
            'id' => null, 'nickname' => $user->nickname, 'name' => null,
            'email' => null, 'avatar' => null,
        ])->setToken($token->getIdentifier(), $token->getSecret());
    }
}
