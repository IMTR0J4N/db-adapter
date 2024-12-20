<?php

namespace DBAdapter\Context\Types;

enum Adapters: string
{
    case MySQL = 'mysql';
    case MongoDB = 'mongodb';
    case UNKNOWN_TEST = '';
}