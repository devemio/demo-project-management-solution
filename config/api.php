<?php

use App\Utils\Api\Method;
use App\Utils\Api\Param;
use App\Utils\Api\Types;

return [

    'users' => [
        new Method('PUT', 'users/{id}', [
            new Param('name'),
            new Param('birth_date'),
            new Param('avatar')
        ])
    ],

    'projects' => [
        new Method('GET', 'projects'),
        new Method('GET', 'projects/{id}'),

        new Method('POST', 'projects', [
            new Param('name', Types::TEXT, true),
            new Param('description', Types::TEXT, true),
            new Param('status', Types::TEXT, true),
            new Param('deadline', Types::DATE, true),
        ]),
        new Method('POST', 'projects/{id}/restore'),

        new Method('PUT', 'projects/{id}', [
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
            new Param('project_id', Types::NUMBER, true),
            new Param('assigned_to', Types::NUMBER, true),
            new Param('name', Types::TEXT, true),
            new Param('description', Types::TEXT, true),
            new Param('status', Types::TEXT, true),
            new Param('deadline', Types::DATE, true),
        ]),
        new Method('POST', 'tasks/{id}/assign', [
            new Param('assigned_to', Types::NUMBER, true),
            new Param('comment'),
        ]),

        new Method('PUT', 'tasks/{id}', [
            new Param('name'),
            new Param('description'),
            new Param('status'),
            new Param('deadline', Types::DATE),
        ]),

        new Method('DELETE', 'tasks/{id}'),
    ]

];