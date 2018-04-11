<?php

namespace rollun\test\datastore\DataStore;

use Interop\Container\ContainerInterface;
use rollun\datastore\DataStore\Interfaces\DataStoresInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractDataStoreTest
 *
 */
abstract class AbstractDataStoreTest extends TestCase
{
    /** @var DataStoresInterface */
    protected $object;

    /** @var ContainerInterface */
    protected $container;

    public function setUp()
    {
        $this->container = require './config/container.php';
        parent::setUp(); // TODO: Change the autogenerated stub
    }
}