<?php

namespace App\Livewire;

use App\Livewire\Actions\Logout;
use App\Models\Message;
use Livewire\Component;
use App\Models\User;

class ChatList extends Component
{
    private $models;

    public $search;

    public $isActiveChat;

    public $perPage = 10;

    public $uid;

    public function loadMore()
    {
        $this->perPage += 10;
    }


    public function chat($uid)
    {
        $this->isActiveChat = null;
        $this->uid = $uid;

        $userId1 = min(auth()->id(), $this->uid);
        $userId2 = max(auth()->id(), $this->uid);


        $this->dispatch('open-chat', uid:$uid, userId1:$userId1, userId2:$userId2, action:'init')->to(ChatMessage::class);
        $this->isActiveChat = $uid;
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        $this->models = User::when($this->search!='', function($query){
            $query->where('name', 'like', '%'.$this->search.'%');
            $query->orWhere('username', 'like', '%'.$this->search.'%');
            $query->orWhere('email', 'like', '%'.$this->search.'%');
        })
        ->where('id','<>', auth()->user()->id)->limit(50)
        ->paginate($this->perPage);

        return view('livewire.chat-list', [
            'models' => $this->models
        ]);
    }
}
