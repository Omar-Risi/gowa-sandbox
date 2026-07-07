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
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Sandbox catcher for Gowa's text-based send endpoints — modeled after
 * Mailpit. Nothing is dispatched to a real WhatsApp/Gowa server; each
 * call is simply captured as a Message so it can be inspected in the
 * dashboard.
 */
class SendMessageController extends Controller
{
    public function message(SendTextMessageRequest $request): JsonResponse
    {
        return $this->capture($request, $request->validated('message'));
    }

    public function contact(SendContactRequest $request): JsonResponse
    {
        $body = sprintf('Contact card: %s (%s)', $request->validated('contact_name'), $request->validated('contact_phone'));

        return $this->capture($request, $body);
    }

    public function link(SendLinkRequest $request): JsonResponse
    {
        $body = trim($request->validated('caption')."\n".$request->validated('link'));

        return $this->capture($request, $body);
    }

    public function location(SendLocationRequest $request): JsonResponse
    {
        $body = sprintf('Location: %s, %s', $request->validated('latitude'), $request->validated('longitude'));

        return $this->capture($request, $body);
    }

    public function poll(SendPollRequest $request): JsonResponse
    {
        $body = sprintf('Poll: %s (%s)', $request->validated('question'), implode(', ', $request->validated('options')));

        return $this->capture($request, $body);
    }

    public function presence(SendPresenceRequest $request): JsonResponse
    {
        return response()->json($this->fakeResponse('presence update', Str::ulid()->toBase32()));
    }

    public function chatPresence(SendChatPresenceRequest $request): JsonResponse
    {
        return response()->json($this->fakeResponse('chat presence update', Str::ulid()->toBase32()));
    }

    private function capture(Request $request, string $body): JsonResponse
    {
        $messageId = strtoupper(Str::ulid()->toBase32());

        Message::create([
            'message_id' => $messageId,
            'chat_jid' => $request->validated('phone'),
            'sender_name' => 'Me',
            'body' => $body,
            'is_from_me' => true,
            'received_at' => now(),
        ]);

        return response()->json($this->fakeResponse('message', $messageId));
    }

    /**
     * @return array<string, mixed>
     */
    private function fakeResponse(string $type, string $messageId): array
    {
        return [
            'code' => 'SUCCESS',
            'message' => 'Success',
            'results' => [
                'message_id' => $messageId,
                'status' => "{$type} captured by sandbox",
            ],
        ];
    }
}
