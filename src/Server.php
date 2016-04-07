<?php

namespace SocialiteProviders\Trello;

use League\OAuth1\Client\Credentials\TokenCredentials;
use SocialiteProviders\Manager\OAuth1\Server as BaseServer;
use SocialiteProviders\Manager\OAuth1\User;

class Server extends BaseServer
{
    /**
     * Access token.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Application key.
     *
     * @var string
     */
    protected $applicationKey;
    
    /**
     * Set the access token.
     *
     * @param string $accessToken
     *
     * @return Trello
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function urlTemporaryCredentials()
    {
        return 'https://trello.com/1/OAuthGetRequestToken';
    }

    /**
     * {@inheritDoc}
     */
    public function urlAuthorization()
    {
        return 'https://trello.com/1/OAuthAuthorizeToken?'.
            $this->buildAuthorizationQueryParameters();
    }

    /**
     * {@inheritDoc}
     */
    public function urlTokenCredentials()
    {
        return 'https://trello.com/1/OAuthGetAccessToken';
    }

    /**
     * {@inheritDoc}
     */
    public function urlUserDetails()
    {
        return 'https://trello.com/1/members/me?key='.$this->applicationKey.'&token='.$this->accessToken;
    }

    /**
     * {@inheritDoc}
     */
    public function userDetails($data, TokenCredentials $tokenCredentials)
    {
        $user = new User();

        $user->nickname = $data['username'];
        $user->name = $data['fullName'];
        $user->imageUrl = null;

        $user->extra = (array) $data;

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function userUid($data, TokenCredentials $tokenCredentials)
    {
        return $data['id'];
    }

    /**
     * {@inheritDoc}
     */
    public function userEmail($data, TokenCredentials $tokenCredentials)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function userScreenName($data, TokenCredentials $tokenCredentials)
    {
        return $data['username'];
    }

    /**
     * Build authorization query parameters.
     *
     * @return string
     */
    private function buildAuthorizationQueryParameters()
    {
        $scopes = $this->formatScopes($this->scopes, $this->scopeSeparator);

        $params = array(
            'response_type' => 'fragment',
            'scope' => $scopes ?: 'read',
            'expiration' => array_get($this->parameters, 'expiration', '1day'),
            'name' => array_get($this->parameters, 'name', null),
        );

        return http_build_query($params);
    }
}
