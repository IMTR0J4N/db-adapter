<?php

namespace DBAdapter\Context\Class;

use MongoDB\BSON\Persistable;

abstract class AbstractDocument implements Persistable {
    abstract public function bsonSerialize();
    abstract public function bsonUnserialize($data);
}