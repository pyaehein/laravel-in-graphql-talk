<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CommentType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Comment',
        'description' => 'A comment'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the comment'
            ],
            'text' => [
                'type' => Type::string(),
                'description' => 'The text of comment'
            ],
            'post_id' => [
                'type' => Type::string(),
                'description' => 'The post id of comment'
            ],
            'user_id' => [
                'type' => Type::string(),
                'description' => 'The user id of comment'
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'The user of comment'
            ],
            'post' => [
                'type' => GraphQL::type('Post'),
                'description' => 'The post of comment'
            ],
        ];
    }
}