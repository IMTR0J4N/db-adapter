<?php

namespace DBConnector\Context\Class;

use MongoDB\BSON\Persistable;

abstract class Document implements Persistable {
    abstract public function bsonSerialize();
    abstract public function bsonUnserialize($data);
}