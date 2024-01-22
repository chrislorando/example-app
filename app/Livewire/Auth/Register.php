<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Register extends Component
{

    #[Rule("required")]
    #[Rule("min:2")]
    public $name;
    #[Rule("required")]
    #[Rule("unique:users,email")]
    #[Rule("min:4")]
    public $email;

    #[Rule("required")]
    #[Rule("confirmed")]
    #[Rule("min:6")]
    public $password;

    #[Rule("required")]
    #[Rule("min:6")]
    public $password_confirmation;
    public function save()
    {
        $this->validate();

        $model = User::create([
            "name"=> $this->name,
            "email"=> $this->email,
            "password"=> bcrypt($this->password),
        ]);

        if($model){
            return $this->redirect('/login', navigate: true);
        }
    }


    #[Layout('components.layouts.auth')]
    public function render()
    {
        return view('livewire.auth.register');
    }
}
