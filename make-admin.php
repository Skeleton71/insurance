<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

// Get email from command line argument or ask user
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    $email = $argv[1];
    echo "Creating admin with email: $email\n";
} else {
    echo "Enter user email to make admin: ";
    $email = trim(fgets(STDIN));
}

if (empty($email)) {
    echo "Email is required.\n";
    exit(1);
}

$user = User::where('email', $email)->first();

if (!$user) {
    echo "User with email '$email' not found.\n";
    exit(1);
}

$user->role = 'admin';
$user->save();

echo "✓ User '$user->name' ($email) is now an ADMIN!\n";
echo "Role: " . strtoupper($user->role) . "\n";
