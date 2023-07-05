<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use App\Http\Controllers\OnboardingConversation; // Import the conversation class

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');
        
        $botman->hears('{message}', function ($botman, $message) {
            if ($message == 'hi' || $message == 'Hi' || $message == 'hello' || $message == 'Hello') {
                $this->startConversation($botman);
            } else {
                $botman->reply("Write 'hi' for testing...");
            }
        });

        $botman->listen();
    }

    public function startConversation($botman)
    {
        $botman->startConversation(new OnboardingConversation());
    }
}
