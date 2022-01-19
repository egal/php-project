<?php

namespace App\InterfaceMetadata;

use App\egal\InterfaceField;
use App\egal\InterfaceFieldTypes;

class ExampleInterfaceMetadata extends \App\egal\EgalIntfaceMetadata
{
    public function setFields()
    {
        $this->fields = [
            'title' => (new InterfaceField('title', InterfaceFieldTypes::STRING))
                ->setComputed([
                    'case' => 'lower'
                ]),
            'channel.title' => (new InterfaceField('channel', InterfaceFieldTypes::STRING))
        ];
    }

    public function setModel()
    {
        $this->model = 'Post';
    }

    public function setRelations()
    {
        $this->relations = [
            'channel'
        ];
    }
}