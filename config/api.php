<?php

use App\Utils\Api\Method;
use App\Utils\Api\Param;
use App\Utils\Api\Types;

return [

    'users' => [
        new Method('PUT', 'users/{user}', [
            new Param('name'),
            new Param('birth_date'),
            new Param('avatar')
        ])
    ],

    'projects' => [
        new Method('GET', 'projects'),
        new Method('GET', 'projects/{id}'),

        new Method('POST', 'projects', [
            new Param('name', Types::STRING, true),
            new Param('description', Types::STRING, true),
            new Param('status', Types::STRING, true),
            new Param('deadline', Types::DATE, true),
        ]),
        new Method('POST', 'projects/{id}/restore'),

        new Method('PUT', 'projects', [
            new Param('name'),
            new Param('description'),
            new Param('status'),
            new Param('deadline', Types::DATE),
        ]),

        new Method('DELETE', 'projects/{id}'),
    ],

    'tasks' => [
        new Method('GET', 'tasks'),
        new Method('GET', 'tasks/assigned'),
        new Method('GET', 'tasks/{id}'),

        new Method('POST', 'tasks', [
            new Param('project_id', Types::INTEGER, true),
            new Param('assigned_to', Types::INTEGER, true),
            new Param('name', Types::STRING, true),
            new Param('description', Types::STRING, true),
            new Param('status', Types::STRING, true),
            new Param('deadline', Types::DATE, true),
        ]),
        new Method('POST', 'tasks/{task}/assign', [
            new Param('assigned_to', Types::INTEGER, true),
            new Param('comment'),
        ]),

        new Method('PUT', 'tasks', [
            new Param('name'),
            new Param('description'),
            new Param('status'),
            new Param('deadline', Types::DATE),
        ]),

        new Method('DELETE', 'tasks/{id}'),
    ]

];