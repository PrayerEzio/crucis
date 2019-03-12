<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Providers;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Contracts\Provider as ProviderInterface;
use Laravel\Socialite\Two\User;
use Illuminate\Support\Arr;
use Illuminate\Http\RedirectResponse;

class QQProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * openid for get user.
     * @var string
     */
    protected $openId;

    /**
     * set Open Id.
     *
     * @param  string  $openId
     */
    public function setOpenId($openId) {
        $this->openId = $openId;

        return $this;
    }

    /**
     * {@inheritdoc}.
     */
    protected $scopes = ['snsapi_login'];

    /**
     * Redirect the user of the application to the provider's authentication screen.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect($state = null)
    {
        return new RedirectResponse($this->getAuthUrl($state));
    }

    /**
     * {@inheritdoc}.
     */
    public function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://graph.qq.com/oauth2.0/authorize', $state);
    }

    /**
     * {@inheritdoc}.
     */
    protected function buildAuthUrlFromBase($url, $state)
    {
        $query = http_build_query($this->getCodeFields($state), '', '&', $this->encodingType);

        return $url.'?'.$query.'#qq_redirect';
    }

    /**
     * {@inheritdoc}.
     */
    protected function getCodeFields($state = null)
    {
        return [
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUrl,
            'response_type' => 'code',
            'scope'         => $this->formatScopes($this->scopes, $this->scopeSeparator),
            'state'         => $state,
        ];
    }

    /**
     * {@inheritdoc}.
     */
    public function getTokenUrl()
    {
        return 'https://graph.qq.com/oauth2.0/token';
    }

    public function getOpenIdUrl()
    {
        return 'https://graph.qq.com/oauth2.0/me';
    }

    /**
     * {@inheritdoc}.
     */
    public function getUserByToken($token)
    {
        $url = "https://graph.qq.com/user/get_user_info";
        $param = [
            'oauth_consumer_key' => $this->clientId,
            'access_token' => $token,
            'openid'       => $this->openId,
        ];
        $url = build_url($url,$param);
        $response = get_url($url);

        return json_decode($response, true);

    }

    /**
     * {@inheritdoc}.
     */
    public function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'openid' => $this->openId,
            'nickname' => $user['nickname'],
            'avatar' => $user['figureurl_2'],
            'name' => $user['nickname'],
            'email' => null,
            'unionid' => $this->openId,
        ]);
    }

    /**
     * {@inheritdoc}.
     */
    protected function getTokenFields($code)
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUrl,
        ];
    }

    protected function getOpenIdFields($token)
    {
        return [
            'access_token' => $token,
        ];
    }

    /**
     * {@inheritdoc}.
     */
    public function getAccessTokenResponse($code)
    {
        $get_token_url = build_url($this->getTokenUrl(),$this->getTokenFields($code));
        $token_response = get_url($get_token_url);
        $tokenResponseBody=[];
        $paramArrs = explode('&', $token_response);
        foreach ($paramArrs as $paramArr)
        {
            $tokenResponseBody[strstr($paramArr, '=', true)] = substr(strstr($paramArr, '='), 1);
        }
        $open_id_url = build_url($this->getOpenIdUrl(),$this->getOpenIdFields($tokenResponseBody['access_token']));
        $open_id_response = get_url($open_id_url);
        $open_id_response = str_replace("callback(","",$open_id_response);
        $open_id_response = str_replace(");","",$open_id_response);
        $open_id_response = json_decode(trim($open_id_response),true);

        $this->setOpenId($open_id_response['openid']);

        return $tokenResponseBody;
    }

    /**
     * {@inheritdoc}
     */
    public function user()
    {

        $response = $this->getAccessTokenResponse($this->getCode());

        $user = $this->mapUserToObject($this->getUserByToken(
            $token = Arr::get($response, 'access_token')
        ));

        return $user->setToken($token)
            ->setRefreshToken(Arr::get($response, 'refresh_token'))
            ->setExpiresIn(Arr::get($response, 'expires_in'));
    }
}