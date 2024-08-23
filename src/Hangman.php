<?php

declare(strict_types=1);

namespace saworo\hangman {

    function randomize(): string {
        $words = ["hello", "world", "php", "developer", "web", "code"];
        return $words[array_rand($words)];
    }

    function show_progress(string $word, array $guessed_letters): void {
        $progress = '';

        foreach (str_split($word) as $letter) {
            $progress .= (in_array($letter, $guessed_letters)) ? $letter : "_";
            $progress .= ' ';
        }

        echo "Current Word: $progress" . PHP_EOL;
    }

    function main(): void {
        $word = randomize();

        $guessed_letters = [];
        $wrong_letters = [];

        echo "How many attempts do you want?: ";
        $remaining_attempts = (int) trim(fgets(STDIN));

        echo "Welcome to PHP Hangman Game!" . PHP_EOL;

        while ($remaining_attempts > 0 && count(array_unique(str_split($word))) != count($guessed_letters)) {
            show_progress($word, $guessed_letters);

            echo "Missed letters: " . implode(", ", $wrong_letters) . PHP_EOL;
            echo "Remaining Attempts: $remaining_attempts";

            echo "Guess a letter: ";
            $letter = strtolower(trim(fgets(STDIN)));

            if (in_array($letter, $guessed_letters) || in_array($letter, $wrong_letters)) {
                echo "You already typed this letter, look for another letter." . PHP_EOL;
            } elseif (str_contains($word, $letter)) {
                $guessed_letters[] = $letter;
                echo "You guessed a letter!" . PHP_EOL;
            } else {
                $wrong_letters[] = $letter;
                $remaining_attempts--;

                echo "Wrong letter." . PHP_EOL;
            }
        }

        if (count(array_unique(str_split($word))) == count($guessed_letters)) {
            echo "Congratulations! You guessed the word: $word" . PHP_EOL;
        } else {
            echo "You lost the game. The word was $word" . PHP_EOL;
        }
    }

    main();
}