<?php

namespace App\Utils;

class Statuses
{
    const TO_DO = 'To do';
    const IN_PROGRESS = 'In progress';
    const IN_QA = 'In QA';
    const DONE = 'Done';

    public static function all(): array
    {
        return [
            Statuses::TO_DO,
            Statuses::IN_PROGRESS,
            Statuses::IN_QA,
            Statuses::DONE,
        ];
    }

    public static function getDefault()
    {
        return Statuses::TO_DO;
    }
}