<?php

namespace DBAdapter\Context\Class;

use MongoDB\BSON\Persistable;

abstract class AbstractDocument implements Persistable {
    abstract public function bsonSerialize(): stdClass|MongoDB\BSON\Document|array;
    abstract public function bsonUnserialize($data): void;
}