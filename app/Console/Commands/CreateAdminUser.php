<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

#[Signature('admin:create')]
#[Description('Create or promote a website administrator without storing a password in source control')]
class CreateAdminUser extends Command
{
    public function handle(): int
    {
        $name = (string) $this->ask('Tên quản trị viên');
        $email = (string) $this->ask('Email', config('website.admin.email'));
        $password = (string) $this->secret('Mật khẩu (tối thiểu 12 ký tự, có chữ hoa, chữ thường, số và ký hiệu)');
        $passwordConfirmation = (string) $this->secret('Nhập lại mật khẩu');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(12)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()->firstOrNew(['email' => mb_strtolower($email)]);
        $user->forceFill([
            'name' => $name,
            'password' => $password,
            'is_admin' => true,
            'email_verified_at' => now(),
        ])->save();

        $this->info('Đã tạo tài khoản quản trị: '.$user->email);

        return self::SUCCESS;
    }
}
