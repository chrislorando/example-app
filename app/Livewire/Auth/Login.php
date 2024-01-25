<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Country AS CountryModel;
class Login extends Component
{
    // #[Rule("required")]
    // #[Rule("min:4")]
    // public $email;

    #[Rule("required")]
    #[Rule("min:4")]
    public $username;

    #[Rule("required")]
    #[Rule("min:6")]
    public $password;
    public $remember = false;

    public function signin()
    {
        $this->validate();

        // if (\Auth::attempt(['email' => $this->email, 'password' => $this->password, 'is_active' => '1'], $this->remember)) {
        //     session()->flash('message', "You are Login successful.");
        //     return $this->redirect('/dashboard');
        // } else {
        //     session()->flash('error', 'Email or password is incorrect.');
        // }

        if (\Auth::attemptWhen([
            'username' => $this->username, 'password' => $this->password
        ], function (User $user) {
            return $user->isNotBanned();
        })) {
            session()->flash('message', __('auth.success'));
            return $this->redirect('dashboard');
        }else{
            session()->flash('error', __('auth.failed'));
        }
    }

    #[Layout('components.layouts.auth')]
    public function render()
    {
        $languages = CountryModel::get();
        return view('livewire.auth.login', [
            'languages' => $languages,
        ]);
    }
}
