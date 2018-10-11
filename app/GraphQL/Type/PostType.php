<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class PostType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Post',
        'description' => 'A post'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the post'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of post'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of post'
            ],
            'user_id' => [
                'type' => Type::string(),
                'description' => 'The user id of post'
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'The user of post'
            ],
            'comments' => [
                'type' => Type::listOf(GraphQL::type('Comment')),
                'description' => 'Comments of post'
            ]
        ];
    }
}