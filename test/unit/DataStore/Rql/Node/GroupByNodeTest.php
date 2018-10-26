<?php

namespace test\unit\DataStore\Rql\Node;

use PHPUnit\Framework\TestCase;
use rollun\datastore\Rql\Node\GroupByNode;

class GroupByNodeTest extends TestCase
{
    protected function createObject(array $fields)
    {
        return new GroupByNode($fields);
    }

    public function dataProvider()
    {
        return [
            [
                [
                    'fieldName1',
                    'fieldName2',
                ],
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param $fields
     */
    public function testConstruct($fields)
    {
        $object = $this->createObject($fields);
        $this->assertEquals($object->getFields(), $fields);
    }

    /**
     * @dataProvider dataProvider
     * @param $fields
     */
    public function testGetNodeName($fields)
    {
        $object = $this->createObject($fields);
        $this->assertEquals($object->getNodeName(), 'groupby');
    }
}
