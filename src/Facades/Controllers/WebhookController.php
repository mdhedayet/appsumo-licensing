<?php

namespace YourNamespace\AppSumo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle incoming webhook requests from AppSumo.
     */
    public function handle(Request $request)
    {
        // Retrieve headers sent by AppSumo
        $signature = $request->header('X-Appsumo-Signature');
        $timestamp = $request->header('X-Appsumo-Timestamp');

        // Retrieve webhook secret from config
        $secret = config('appsumo.webhook_secret');

        // Compute HMAC SHA256 of (timestamp + request body)
        $payload = $timestamp . $request->getContent();
        $computedSignature = hash_hmac('sha256', $payload, $secret);

        // Validate signature – if mismatch, reject the request
        if (!hash_equals($computedSignature, $signature)) {
            Log::warning('Invalid AppSumo webhook signature', [
                'computed' => $computedSignature,
                'provided' => $signature,
            ]);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        // Retrieve the JSON payload
        $data = $request->json()->all();

        // (Optional) Skip processing if this is a test webhook
        if (isset($data['test']) && $data['test'] === true) {
            return response()->json([
                'success' => true,
                'event'   => $data['event'] ?? 'unknown',
                'message' => 'Test event received.',
            ]);
        }

        // Process the event automatically (e.g., update license status, create or update user, etc.)
        // You can use a switch/case block to process different events (purchase, activate, upgrade, downgrade, deactivate)
        switch ($data['event'] ?? '') {
            case 'purchase':
                // Create a placeholder account if needed.
                Log::info('AppSumo purchase event received', $data);
                break;

            case 'activate':
                // Activate the license.
                Log::info('AppSumo activate event received', $data);
                break;

            case 'upgrade':
            case 'downgrade':
                // Handle tier changes.
                Log::info('AppSumo tier change event received', $data);
                break;

            case 'deactivate':
                // Deactivate the license.
                Log::info('AppSumo deactivate event received', $data);
                break;

            default:
                Log::warning('Unknown AppSumo event', $data);
                break;
        }

        // Respond with success per AppSumo’s requirements.
        return response()->json([
            'success' => true,
            'event'   => $data['event'] ?? 'unknown',
            'message' => 'Webhook processed successfully',
        ], 200);
    }
}
