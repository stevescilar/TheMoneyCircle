<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create 
                            {--name= : Full name of the Super Admin}
                            {--email= : Email address}
                            {--password= : Login password}
                            {--title=Super Administrator : Title or Designation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or promote a user to Super Admin with full dashboard access';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('=== The Money Circle - Super Admin Creator ===');

        // Name
        $name = $this->option('name');
        if (empty($name)) {
            $name = $this->ask('Enter the Super Admin full name', 'Super Admin');
        }

        // Email
        $email = $this->option('email');
        if (empty($email)) {
            $email = $this->ask('Enter the Super Admin email address');
        }

        $validator = Validator::make(['email' => $email], [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            $this->error('Invalid email address provided: ' . $validator->errors()->first('email'));
            return Command::FAILURE;
        }

        // Password
        $password = $this->option('password');
        if (empty($password)) {
            $password = $this->secret('Enter password for the Super Admin (min 8 characters)');
            $confirmPassword = $this->secret('Confirm password');

            if ($password !== $confirmPassword) {
                $this->error('Passwords do not match. Please try again.');
                return Command::FAILURE;
            }
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');
            return Command::FAILURE;
        }

        $title = $this->option('title') ?: 'Super Administrator';

        // Check if user exists
        $user = User::where('email', $email)->first();

        if ($user) {
            $this->warn("User with email [{$email}] already exists. Promoting to Super Admin and updating password...");
            $user->update([
                'name' => $name,
                'role' => 'super_admin',
                'title' => $title,
                'password' => Hash::make($password),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
            $action = 'Updated & Promoted';
        } else {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'role' => 'super_admin',
                'title' => $title,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);
            $action = 'Created';
        }

        $this->newLine();
        $this->info("✓ Super Admin successfully {$action}!");
        $this->table(
            ['Field', 'Value'],
            [
                ['ID', $user->id],
                ['Name', $user->name],
                ['Email', $user->email],
                ['Role', $user->role],
                ['Title', $user->title],
                ['Dashboard Access', 'Full Access (Verified)'],
                ['Login URL', url('/login')],
                ['Dashboard URL', url('/coach-dashboard')],
            ]
        );

        return Command::SUCCESS;
    }
}

