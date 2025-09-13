<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Twilio\Rest\Client;
use Exception;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('whatsapp');
    }

    public function store(Request $request)
    {
        $twilioSid   = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioSmsNumber = env('TWILIO_SMS_NUMBER'); // <-- Your Twilio purchased phone number
        $message = $request->message;
        $recipientNumber = "+919737052668"; // or $request->phone in E.164 format

        try {
            $twilio = new Client($twilioSid, $twilioToken);
            $twilio->messages->create(
                $recipientNumber, // ✅ SMS does NOT need whatsapp:
                [
                    "from" => $twilioSmsNumber, // ✅ must be a Twilio SMS-enabled number
                    "body" => $message,
                ]
            );

            return back()->with(['success' => 'SMS sent successfully!']);
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
