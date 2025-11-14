<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Validate the webhook signature (if using a secret)
        $secret = config('services.github.webhook_secret'); // Add this to your services config file
        $signature = $request->header('X-Hub-Signature') ?? '';

        if (!$this->isValidSignature($request->getContent(), $signature, $secret)) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Handle the event
        $event = $request->header('X-GitHub-Event');
        $payload = $request->all();

        switch ($event) {
            case 'push':
                $this->handlePushEvent($payload);
                break;

            default:
                return response()->json(['message' => 'Event not handled'], 200);
        }

        return response()->json(['message' => 'Webhook handled'], 200);
    }

    private function isValidSignature($payload, $signature, $secret)
    {
        $hash = 'sha1=' . hash_hmac('sha1', $payload, $secret);
        return hash_equals($hash, $signature);
    }

    private function handlePushEvent($payload)
    {
        $repoPath = '/home/earnifyx/order.kingpinwears.com'; // <-- adjust to your repo root

        $commands = [
            "cd {$repoPath}",
            'git reset --hard',
            'git pull origin main',
            'composer install --no-dev',
            'php artisan migrate --force',
            'php artisan cache:clear',
        ];

        $commandString = implode(' && ', $commands) . ' 2>&1';

        $output = shell_exec($commandString);

        // Log the output for debugging
        file_put_contents($repoPath . '/deploy.log', $output . PHP_EOL, FILE_APPEND);
    }
}
