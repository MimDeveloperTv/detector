<?php

namespace App\Foundation\Logging\HttpClient;

use GuzzleHttp\Psr7\Message;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PsrMessageConverter
{
    public static function toString(MessageInterface $message): string
    {
        return Message::toString($message);
    }

    /**
     * @param  string  $message
     * @return RequestInterface
     */
    public static function toRequest(string $message): RequestInterface
    {
        return Message::parseRequest($message);
    }

    /**
     * @param  string  $message
     * @return ResponseInterface
     */
    public static function toResponse(string $message): ResponseInterface
    {
        return Message::parseResponse($message);
    }
}
