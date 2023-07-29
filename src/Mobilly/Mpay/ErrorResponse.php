<?php declare(strict_types=1);

namespace Mobilly\Mpay;

/**
 * Error response.
 * @package Mobilly\Mpay
 */
class ErrorResponse extends Response
{
    public static function withMessage(string $message): ErrorResponse
    {
        return new ErrorResponse(json_encode(['message' => $message]));
    }
}