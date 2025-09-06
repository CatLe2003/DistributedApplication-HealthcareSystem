<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\RabbitMQHelper;

class PublishRabbitMQLog
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('api/*')) {

            $status = $response->getStatusCode();
            $level = 'INFO';

            if ($status >= 400) {
                $level = 'ERROR';
            } 

            RabbitMQHelper::publish('log_exchange', [
                'event' => $request->method() . ' ' . $request->path(),
                'service' => 'NotificationService',
                'ipAddress' => $request->ip(),
                'level' => $level,
                'status' => $status,
                'response' => $response,
                'user' => $request->json('user') || null
            ]);
        }

        return $response;
    }
}