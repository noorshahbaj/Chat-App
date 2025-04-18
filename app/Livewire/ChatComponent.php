<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\MessageSendEvent;

class ChatComponent extends Component
{
    public $user;
    public $senderId;
    public $receiverId;
    public $message = '';
    public $messages = [];

    public function mount(User $user)
    {
        $this->senderId = auth()->id();
        $this->receiverId = $user->id;

        $messages = Message::with('sender:id,name', 'receiver:id,name')
            ->where(function ($query) {
                $query->where('sender_id', $this->senderId)
                    ->where('receiver_id', $this->receiverId);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->receiverId)
                    ->where('receiver_id', $this->senderId);
            })->orderBy('created_at', 'asc')->get();

        foreach ($messages as $message) {
            $this->appendChatMessage($message);
        }

        $this->user = $user;
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string'
        ]);

        $chatMessage = Message::create([
            'sender_id' => $this->senderId,
            'receiver_id' => $this->receiverId,
            'message' => $this->message
        ]);

        $this->appendChatMessage($chatMessage);

        broadcast(new MessageSendEvent($chatMessage))->toOthers();

        $this->message = '';
    }

    #[On('echo-private:chat-channel.{senderId},MessageSendEvent')]
    public function listenForMessage($event)
    {
        $chatMessage = Message::whereId($event['message']['id'])
            ->with('sender:id,name', 'receiver:id,name')
            ->first();

        $this->appendChatMessage($chatMessage);
    }

    public function appendChatMessage($message)
    {
        $this->messages[] = [
            'id' => $message->id,
            'sender' => $message->sender->name,
            'receiver' => $message->receiver->name,
            'message' => $message->message,
            'created_at' => $message->created_at->diffForHumans(),
        ];
    }

    public function render()
    {
        return view('livewire.chat-component');
    }
}
