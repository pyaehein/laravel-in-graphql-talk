<?php

namespace App\GraphQL\Type;

use Carbon\Carbon;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A user'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the user'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of user'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user'
            ],
            'posts' => [
                'type' => Type::listOf(GraphQL::type('Post')),
                'description' => 'Posts of user'
            ],
            'comments' => [
                'args' => [
                    'id' => [
                        'type' => Type::string(),
                        'description' => 'The id of comment'
                    ]
                ],
                'resolve' => function($root, $args) {
                    $comment = $root->comments();
                    if (isset($args['id'])) {
                        $comment = $comment->where('id', $args['id']);
                    }
                    return $comment->get();
                },
                'type' => Type::listOf(GraphQL::type('Comment')),
                'description' => 'Comments of user'
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The created at of user'
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The updated at of user'
            ]
        ];
    }

    protected function resolveNameField($root, $args)
    {
        return strtolower($root->name);
    }

    protected function resolveCreatedAtField($root, $args)
    {
        return (String) $root->updated_at;
    }

    protected function resolveUpdatedAtField($root, $args)
    {
        return (String) $root->updated_at;
    }
}