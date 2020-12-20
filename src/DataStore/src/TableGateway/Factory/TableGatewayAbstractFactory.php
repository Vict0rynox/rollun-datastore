<?php
/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */

namespace rollun\datastore\TableGateway\Factory;

use Interop\Container\ContainerInterface;
use rollun\datastore\AbstractFactoryAbstract;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

/**
 * Create and return an instance of the TableGateway
 * This Factory depends on Container (which should return an 'config' as array)
 *
 * The configuration can contain:
 * <code>
 *  'tableGateway' => [
 *      'sql' => 'Zend\Db\Sql\Sql', // optional
 *      'adapter' => 'db' // optional,
 *  ],
 * </code>
 *
 * Class TableGatewayAbstractFactory
 * @package rollun\datastore\TableGateway\Factory
 */
class TableGatewayAbstractFactory extends AbstractFactoryAbstract
{
    const KEY_SQL = 'sql';

    const KEY_TABLE_GATEWAY = 'tableGateway';

    const KEY_ADAPTER = 'adapter';

    /**
     * @var null|array
     */
    protected $tableNames = null;

    /**
     * @var Adapter
     */
    protected $db;

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config');

        if (!isset($config[self::KEY_TABLE_GATEWAY][$requestedName])) {
            return false;
        }
        return true;
    }

    /**
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @return Adapter|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getDbAdapter(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config')[self::KEY_TABLE_GATEWAY];

        if (isset($config[$requestedName]) && isset($config[$requestedName][static::KEY_ADAPTER])) {
            return $container->has($config[$requestedName][static::KEY_ADAPTER])
                ? $container->get($config[$requestedName][static::KEY_ADAPTER])
                : null;
        } else {
            return $container->has('db') ? $container->get('db') : null;
        }
    }

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return \rollun\datastore\DataStore\Interfaces\DataStoresInterface|TableGateway
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config')[self::KEY_TABLE_GATEWAY][$requestedName];
        $db = $this->getDbAdapter($container, $requestedName);

        if (isset($config[self::KEY_SQL]) && is_a($config[self::KEY_SQL], 'Zend\Db\Sql\Sql', true)) {
            $sql = new $config[self::KEY_SQL]($db, $requestedName);

            return new TableGateway($requestedName, $db, null, null, $sql);
        }

        return new TableGateway($requestedName, $db);
    }
}
