<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $employee_id;
    public $password;

    protected $rules = [
        'employee_id' => 'required',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['employee_id' => $this->employee_id, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended('/');
        }

        $this->addError('employee_id', '員工編號或密碼錯誤。');
    }

    public function loginViaLine($lineUserId)
    {
        $user = \App\Models\User::where('line_user_id', $lineUserId)->where('is_active', true)->first();

        if ($user) {
            Auth::login($user);
            session()->regenerate();
            return redirect()->intended('/');
        }

        $this->addError('employee_id', '此 LINE 帳號未連結任何員工，請先以編號登入並於設定中綁定。');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.app');
    }
}
