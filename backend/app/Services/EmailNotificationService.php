<?php

namespace App\Services;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\WargaNotificationMail;

class EmailNotificationService
{
    /**
     * Send an email notification to a user if their client (RW) has email gateway active.
     * 
     * @param User $user
     * @param string $subject
     * @param string $message
     * @return bool
     */
    public static function send(User $user, $subject, $message)
    {
        // Get the user's client
        $client = Client::find($user->client_id);

        if (!$client) {
            return false; // No client associated
        }

        // Check if Superadmin has enabled Email Notifications for this Client
        if (!$client->is_email_notification_active) {
            return false; // Gateway is turned OFF for this RW
        }

        // Check if User has an email
        if (empty($user->email)) {
            return false; // No email to send to
        }

        try {
            // Queue the email sending to avoid blocking the request
            Mail::to($user->email)->send(new WargaNotificationMail($subject, $message, $user->name));
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send Email Notification: ' . $e->getMessage());
            return false;
        }
    }
}
