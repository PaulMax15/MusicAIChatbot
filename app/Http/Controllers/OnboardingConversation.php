<?php

namespace App\Http\Controllers;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class OnboardingConversation extends Conversation
{
    public function run()
    {
        $this->askName();
    }

    public function askName()
    {
        $this->ask('Hello! What is your name?', function (Answer $answer) {
            $name = $answer->getText();

            $this->bot->userStorage()->save([
                'name' => $name
            ]);

            $this->say("Nice to meet you, $name");
            $this->askFeeling();
        });
    }

    public function askFeeling()
{
    $this->ask('How are you feeling today? (sad - 1, happy - 2, angry - 3)', function (Answer $answer) {
        $feeling = strtolower($answer->getText());

        $songs = [];
        
        switch ($feeling) {
            case '1':
                $songs = [
                    [
                        'title' => 'Let Her Go',
                        'artist' => 'Passenger',
                        'genre' => 'Folk',
                        'year' => '2012'
                    ],
                    [
                        'title' => 'Wish You The Best',
                        'artist' => 'Lewis Capaldi',
                        'genre' => 'Pop',
                        'year' => '2019'
                    ],
                    [
                        'title' => 'Chamber Of Reflection',
                        'artist' => 'Mac DeMarco',
                        'genre' => 'Indie',
                        'year' => '2014'
                    ]
                ];
                break;
            case '2':
                $songs = [
                    [
                        'title' => 'Happy',
                        'artist' => 'Pharrell Williams',
                        'genre' => 'Pop',
                        'year' => '2013'
                        
                    ],
                    [
                        'title' => 'Lotus Eater',
                        'artist' => 'Foster The People',
                        'genre' => 'Indie',
                        'year' => '2017'
                    ],
                    [
                        'title' => 'Tom & Jerry',
                        'artist' => 'Ocean Wisdom',
                        'genre' => 'Hip Hop',
                        'year' => '2020'
                    ]
                ];
                break;
            case '3':
                $songs = [
                    [
                        'title' => 'Skeptic',
                        'artist' => 'Snapcase',
                        'genre' => 'Hardcore',
                        'year' => '1997'
                    ],
                    [
                        'title' => 'Chop Suey!',
                        'artist' => 'System of a Down',
                        'genre' => 'Metal',
                        'year' => '2001'
                    ],
                    [
                        'title' => 'The Mirror',
                        'artist' => 'Dream Theater',
                        'genre' => 'Progressive Metal',
                        'year' => '1994'
                    ]
                ];
                break;
            default:
                $songs = [['title' => 'Type a number based on the feelings above!']];
        }

        if ($songs[0]['title'] !== 'Type a number based on the feelings above!') {
            $this->say("Here are some songs for you to try:\n");

            foreach ($songs as $song) {
                $this->say("Title: {$song['title']}");
                $this->say("Artist: {$song['artist']}");
                $this->say("Genre: {$song['genre']}");
                $this->say("Released Year: {$song['year']}");
                $this->say("----------");
            }
        } else {
            $this->say($songs[0]['title']);
        }

        $this->askConfirmation();
    });
}


    

    public function askConfirmation()
{
    $this->ask('Is there anything I can help you with?', function (Answer $answer) {
        $confirmation = strtolower($answer->getText());

        if ($confirmation == 'thank you') {
            $this->say("You're welcome!");
        } else if($confirmation == 'no' || $confirmation == 'No'){
            $this->askFeeling();
        }
    });
}

}
