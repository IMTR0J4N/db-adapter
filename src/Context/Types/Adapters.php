<?php

namespace DBConnector\Context\Types;

enum Adapters: string
{
    case MySQL = 'mysql';
    case MongoDB = 'mongodb';
}