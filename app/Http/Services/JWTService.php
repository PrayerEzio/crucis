<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Services;

use Tymon\JWTAuth\Contracts\Providers\JWT as JWTContract;

class JWTService
{
    /**
     * The provider.
     *
     * @var \Tymon\JWTAuth\Contracts\Providers\JWT
     */
    protected $provider;

    /**
     * Constructor.
     *
     * @param  \Tymon\JWTAuth\Contracts\Providers\JWT  $provider
     * @param  \Tymon\JWTAuth\Blacklist  $blacklist
     * @param  \Tymon\JWTAuth\Factory  $payloadFactory
     *
     * @return void
     */
    public function __construct(JWTContract $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Decode a Token and return the Payload.
     *
     * @param  \Tymon\JWTAuth\Token  $token
     * @param  bool  $checkBlacklist
     *
     * @throws \Tymon\JWTAuth\Exceptions\TokenBlacklistedException
     *
     * @return \Tymon\JWTAuth\Payload
     */
    public function decode($token)
    {
        $payloadArray = $this->provider->decode($token);

        return $payloadArray;
    }
}