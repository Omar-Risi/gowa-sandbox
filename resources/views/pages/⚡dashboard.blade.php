<?php

use App\Models\Message;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard')] class extends Component
{
    public ?int $selectedId = null;

    public int $lastKnownId = 0;

    public function mount(): void
    {
        $latest = $this->messages->first();

        if ($latest) {
            $this->selectedId = $latest->id;
            $this->lastKnownId = $latest->id;
        }
    }

    #[Computed]
    public function messages(): Collection
    {
        return Message::query()->orderByDesc('received_at')->limit(100)->get();
    }

    #[Computed]
    public function selectedMessage(): ?Message
    {
        return $this->messages->firstWhere('id', $this->selectedId);
    }

    public function selectMessage(int $id): void
    {
        $this->selectedId = $id;
    }

    public function poll(): void
    {
        $latest = Message::query()->latest('id')->first();

        if ($latest && $latest->id > $this->lastKnownId) {
            $this->lastKnownId = $latest->id;
            $this->selectedId = $latest->id;
            $this->dispatch('new-message-received', id: $latest->id);
        }
    }
};
?>

<div
    x-data="{ flashId: null }"
    x-on:new-message-received.window="flashId = $event.detail.id; setTimeout(() => flashId = null, 1500)"
    wire:poll.3s="poll"
    class="flex h-screen bg-neutral-50 text-neutral-900"
>
    {{-- Message list --}}
    <div class="flex w-80 flex-shrink-0 flex-col border-r border-neutral-200 bg-white">
        <div class="flex items-center justify-between border-b border-neutral-200 px-4 py-3">
            <h1 class="text-sm font-semibold text-neutral-900">Messages</h1>
            <span class="rounded-full bg-neutral-100 px-2 py-0.5 text-xs font-medium text-neutral-500">
                {{ $this->messages->count() }}
            </span>
        </div>

        <div class="flex-1 overflow-y-auto">
            @forelse ($this->messages as $message)
                <button
                    type="button"
                    wire:key="message-{{ $message->id }}"
                    wire:click="selectMessage({{ $message->id }})"
                    x-bind:class="flashId === {{ $message->id }} ? 'bg-emerald-50' : (@js($this->selectedId === $message->id) ? 'bg-neutral-100' : 'hover:bg-neutral-50')"
                    class="w-full border-b border-neutral-100 px-4 py-3 text-left transition-colors duration-500"
                >
                    <div class="flex items-center justify-between gap-2">
                        <span class="truncate text-sm font-medium text-neutral-900">
                            {{ $message->sender_name ?? $message->chat_jid }}
                        </span>
                        <span class="flex-shrink-0 text-xs text-neutral-400" title="{{ $message->received_at }}">
                            {{ $message->received_at->diffForHumans(short: true) }}
                        </span>
                    </div>
                    <p class="mt-1 truncate text-sm text-neutral-500">{{ $message->body }}</p>
                </button>
            @empty
                <div class="p-4 text-sm text-neutral-400">
                    No messages yet. Send one via <code class="text-xs">POST /api/v1/send/message</code>.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Message details --}}
    <div class="flex-1 overflow-y-auto p-8">
        @if ($this->selectedMessage)
            <div class="mx-auto max-w-2xl">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-neutral-900">
                            {{ $this->selectedMessage->sender_name ?? $this->selectedMessage->chat_jid }}
                        </h2>
                        <p class="text-sm text-neutral-500">{{ $this->selectedMessage->chat_jid }}</p>
                    </div>
                    <span class="rounded-full bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-500">
                        {{ $this->selectedMessage->is_from_me ? 'Sent' : 'Received' }}
                    </span>
                </div>

                <p class="mt-6 whitespace-pre-wrap text-base text-neutral-800">
                    {{ $this->selectedMessage->body }}
                </p>

                <dl class="mt-10 grid grid-cols-2 gap-4 border-t border-neutral-200 pt-6 text-sm">
                    <div>
                        <dt class="text-neutral-400">Message ID</dt>
                        <dd class="mt-1 font-mono text-neutral-700">{{ $this->selectedMessage->message_id ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-neutral-400">Received at</dt>
                        <dd class="mt-1 text-neutral-700">{{ $this->selectedMessage->received_at }}</dd>
                    </div>
                </dl>
            </div>
        @else
            <div class="flex h-full items-center justify-center text-sm text-neutral-400">
                Select a message to see its details.
            </div>
        @endif
    </div>
</div>
