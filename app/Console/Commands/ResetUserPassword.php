<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password dan verifikasi email untuk user tertentu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email    = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("User dengan email [{$email}] tidak ditemukan.");
            return 1;
        }

        $user->update([
            'password'          => Hash::make($password),
            'email_verified_at' => $user->email_verified_at ?? now(),
        ]);

        $this->info("✅ Password berhasil direset untuk: {$user->name} ({$user->email})");
        $this->line("   Role             : {$user->role}");
        $this->line("   Email verified   : {$user->fresh()->email_verified_at}");
        $this->line("   Hash check       : " . (Hash::check($password, $user->fresh()->password) ? 'MATCH ✓' : 'MISMATCH ✗'));

        return 0;
    }
}
