<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Message;

class ChatMessage extends Component
{
    public $models;

    public User $userModel;

    public $uid;

    public $message;

    public $showChat = false;

    public function mount()
    {
        $this->userModel = new User();
    }

    #[On('open-chat')] 
    public function refreshChat($uid)
    {
        $this->uid = $uid;
        $this->showChat = true;
       
    }
    public function render()
    {
        $this->models = Message::where('sender_id', auth()->id())
        ->where('receiver_id', $this->uid)
        ->orWhere('sender_id', $this->uid)
        ->where('receiver_id', auth()->id())
        ->orderBy('timestamp','asc')
        ->get();

        if($this->uid)
        {
            $this->userModel = User::find($this->uid);
        }
      


        return view('livewire.chat-message');
    }
}
