<?php
namespace SocialiteProviders\Trello;

use SocialiteProviders\Manager\SocialiteWasCalled;

class TrelloExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'trello', __NAMESPACE__.'\Provider',
            'League\OAuth1\Client\Server\Trello'
        );
    }
}
