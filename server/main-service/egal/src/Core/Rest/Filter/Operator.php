<?php

namespace Egal\Core\Rest\Filter;

enum Operator: string
{
    case Equal = 'eq';
    case GreaterThen = 'gt';
}
