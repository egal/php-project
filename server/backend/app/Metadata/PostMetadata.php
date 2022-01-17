<?php

use App\egal\EgalMetadata;

class PostMetadata extends EgalMetadata
{
    private $metadata = [
        'title' => [
          'validation_rules' => [],
          'name' => '',
          'type' => '',
          'access' => [] // массив ролей
        ],
        'content' => [
            'validation_rules' => [],
            'name' => '',
            'type' => '',
            'access' => [] // массив ролей
        ],
    ];
    public function getAttributeNameValidationRule(string $attribute): array
    {
    }
}
