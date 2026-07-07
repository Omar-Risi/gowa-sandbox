<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SendChatPresenceRequest;
use App\Http\Requests\Api\V1\SendContactRequest;
use App\Http\Requests\Api\V1\SendLinkRequest;
use App\Http\Requests\Api\V1\SendLocationRequest;
use App\Http\Requests\Api\V1\SendPollRequest;
use App\Http\Requests\Api\V1\SendPresenceRequest;
use App\Http\Requests\Api\V1\SendTextMessageRequest;
use App\Services\GowaClient;
use Illuminate\Http\JsonResponse;

class SendMessageController extends Controller
{
    public function __construct(private GowaClient $gowa) {}

    public function message(SendTextMessageRequest $request): JsonResponse
    {
        return $this->forward('/send/message', $request);
    }

    public function contact(SendContactRequest $request): JsonResponse
    {
        return $this->forward('/send/contact', $request);
    }

    public function link(SendLinkRequest $request): JsonResponse
    {
        return $this->forward('/send/link', $request);
    }

    public function location(SendLocationRequest $request): JsonResponse
    {
        return $this->forward('/send/location', $request);
    }

    public function poll(SendPollRequest $request): JsonResponse
    {
        return $this->forward('/send/poll', $request);
    }

    public function presence(SendPresenceRequest $request): JsonResponse
    {
        return $this->forward('/send/presence', $request);
    }

    public function chatPresence(SendChatPresenceRequest $request): JsonResponse
    {
        return $this->forward('/send/chat-presence', $request);
    }

    private function forward(string $path, SendTextMessageRequest|SendContactRequest|SendLinkRequest|SendLocationRequest|SendPollRequest|SendPresenceRequest|SendChatPresenceRequest $request): JsonResponse
    {
        $response = $this->gowa->post($path, $request->validated(), $request->header('X-Device-Id'));

        return response()->json($response->json(), $response->status());
    }
}
