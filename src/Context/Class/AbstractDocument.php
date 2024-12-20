<?php

namespace DBAdapter\Context\Class;

use MongoDB\BSON\Persistable;
use MongoDB\BSON\Document;
use stdClass;

abstract class AbstractDocument implements Persistable {
    abstract public function bsonSerialize(): stdClass|Document|array;
    abstract public function bsonUnserialize($data): void;
}