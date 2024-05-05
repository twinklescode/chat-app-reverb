<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use App\Models\User;

class ChatList extends Component
{
    public $models;

    public $search;

    public $isActiveChat;


    public function chat($uid)
    {
        $this->dispatch('open-chat', uid:$uid)->to(ChatMessage::class);
        $this->isActiveChat = $uid;
    }

    public function render()
    {
        $this->models = User::when($this->search!='', function($query){
            $query->where('name', 'like', '%'.$this->search.'%');
            $query->orWhere('username', 'like', '%'.$this->search.'%');
            $query->orWhere('email', 'like', '%'.$this->search.'%');
        })
        ->where('id','<>', auth()->user()->id)->limit(50)
        ->get();
        return view('livewire.chat-list');
    }
}
