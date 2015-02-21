<?php
namespace SocialiteProviders\Trello;

use SocialiteProviders\Manager\SocialiteWasCalled;

class TrelloExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'trello',
            __NAMESPACE__.'\Provider',
            'League\OAuth1\Client\Server\Trello'
        );
    }
}
