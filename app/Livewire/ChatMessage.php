<?php

namespace App\Livewire;

use App\Events\PushMessage;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use App\Models\Message;

class ChatMessage extends Component
{
    private $models;

    private $oldModels;

    public User $userModel;

    public $uid;

    public $userId1;

    public $userId2;

    public string $message;

    public $showChat = false;

    public $perPage = 10;

    public $key;

    public $targetSender;
    public $targetMessageId;
    public $targetMessageText;


    public function mount()
    {
        $this->userModel = new User();   
        $this->dispatch('$refresh');

    }

    // #[Renderless]
    // #[On('loadMore')] 
    public function loadMore()
    {
        $this->perPage += 5;
    }

   
    public function send()
    {
        $this->dispatch('$refresh');
        Message::create([
            'sender_id'=> auth()->id(),
            'receiver_id'=> $this->uid,
            'parent_id'=> $this->targetMessageId,
            'content' => $this->message,
            'timestamp' => now()
        ]);

        $this->userId1 = min(auth()->id(), $this->uid);
        $this->userId2 = max(auth()->id(), $this->uid);

        event(new PushMessage($this->userId1, $this->userId2, $this->message));

        $this->reset(['message','targetMessageId','targetMessageText','targetSender']);
        // $this->dispatch('$refresh');
    }

    public function sendPublic()
    {
           // Broadcast::on('private-room.'.auth()->id())->sendNow();
        //    event(new PushMessage(auth()->id(), 'Private message'));
           // broadcast(new PushMessage(auth()->id(), $this->message));
           // $this->dispatch('open-chat', uid:$this->uid)->to(ChatMessage::class);
           // dd($this->message);
    }

    public function sendPrivate()
    {
        // Broadcast::on('private-room.'.auth()->id())->sendNow();
        // event(new PushMessage(auth()->id(), 'Private message'));
        // broadcast(new PushMessage(auth()->id(), $this->message));
        // $this->dispatch('open-chat', uid:$this->uid)->to(ChatMessage::class);
        // dd($this->message);
    }

    public function getListeners()
    {
        // Check if both user IDs are available
        if ($this->userId1 !== null && $this->userId2 !== null) {
            // dd("echo-private:room.{$this->userId1}.{$this->userId2},PushMessage");
            // Return the listener for the private channel with the appropriate channel name
            return [
                // "echo-private:room.{$this->userId1}.{$this->userId2},PushMessage" => 'pushMessage',
                 "echo-private:room.{$this->userId1}.{$this->userId2},.PushMessage" => 'pushMessage',
            ];
        }else{
             // If user IDs are not available, return an empty array
            // return [
            //     "echo-private:room,PushMessage" => 'pushMessage',
            // ];

            return [];
        }
       

        // return [
        //     "echo-private:room.{$this->userId1}.{$this->userId2},.PushMessage" => 'pushMessage',
        // ];
    }

    #[On('open-chat')] 
    public function refreshChat($uid, $userId1, $userId2, $action=null)
    {
        $this->uid = $uid;
        $this->userId1 = $userId1;
        $this->userId2 = $userId2;
        $this->showChat = true;
        $this->message = "";
        $this->dispatch('$refresh');
        // dd('asd');
        // event(new PushMessage($this->userId1, $this->userId2, 'ENTER'));

    }

    #[On('echo:room,PushMessage')] 
    public function testAllChannel($data)
    {
        // dd("NOT PRIVATE");
        // $this->dispatch('open-chat', uid:$this->uid)->to(ChatMessage::class);
    }

    // #[On('echo-private:room.{uid},PushMessage')] 
    #[On('triggerMessage')] 
    public function pushMessage()
    {
        // dd($event);
        // dd("echo-private:room.".$this->userId1.".".$this->userId2);
        // $this->dispatch('open-chat', uid:$this->uid)->to(ChatMessage::class);

        $this->dispatch('$refresh');
    }

    public function reply(Message $model)
    {
        $this->targetSender = $model->sender->name;
        $this->targetMessageId = $model->id;
        $this->targetMessageText = $model->content;
    }


    public function clearReply()
    {
        $this->targetSender = null;
        $this->targetMessageId = null;
        $this->targetMessageText = null;
    }


    public function remove(Message $model)
    {
        $model->delete();
      
        $this->userId1 = min(auth()->id(), $this->uid);
        $this->userId2 = max(auth()->id(), $this->uid);

        event(new PushMessage($this->userId1, $this->userId2, $this->message));
    }

    public function render()
    {
        $this->models = [];
        $this->models = Message::where('sender_id', auth()->id())
        ->where('receiver_id', $this->uid)
        ->orWhere('sender_id', $this->uid)
        ->where('receiver_id', auth()->id())
        // ->take(5)
        ->orderBy('id','desc')
        // ->latest()
        ->paginate($this->perPage);
        

        if($this->uid)
        {
            $this->userModel = User::find($this->uid);
        }
      

        return view('livewire.chat-message', [
            'models' => $this->models,
        ]);
    }
}
