<?php /** @noinspection PhpComposerExtensionStubsInspection */

namespace XF\Db\PostgreSql;

use XF\Db\Exception;
use XF\Db\ForeignAdapter;

class Adapter extends ForeignAdapter
{
	/**
	 * @var resource
	 */
	protected $connection;

	protected function getStatementClass()
	{
		return 'XF\Db\PostgreSql\Statement';
	}

	/**
	 * @return resource
	 * @throws \XF\Db\Exception
	 */
	public function getConnection()
	{
		if (!$this->connection)
		{
			$this->connection = $this->makeConnection($this->config);
		}

		return $this->connection;
	}

	protected function _rawQuery($query)
	{
		$connection = $this->getConnection();
		return pg_query($connection, $query);
	}

	public function isConnected()
	{
		$connection = $this->getConnection();
		return pg_connection_status($connection) === PGSQL_CONNECTION_OK;
	}

	public function ping()
	{
		$connection = $this->getConnection();
		return pg_ping($connection);
	}

	public function lastInsertId()
	{
		// note: no (viable) equivalent in PostgreSQL
		throw new Exception('It is not possible to retrieve the PostgreSQL last insert ID at this time.');
	}

	public function getServerVersion()
	{
		$connection = $this->getConnection();
		$version = pg_version($connection);
		return $version['server'] ?? null;
	}

	public function getConnectionStats()
	{
		// note: no equivalent in PostgreSQL
		return [];
	}

	public function escapeString($string)
	{
		$connection = $this->getConnection();
		return pg_escape_string($connection, $string);
	}

	public function getDefaultTableConfig()
	{
		// note: no equivalent in PostgreSQL
		return [];
	}

	/**
	 * @param array $config
	 *
	 * @return resource
	 * @throws \XF\Db\Exception
	 */
	protected function makeConnection(array $config)
	{
		$config = $this->standardizeConfig($config);

		try
		{
			$connection = pg_connect("host=$config[host] port=$config[port] dbname=$config[dbname] user=$config[username] password=$config[password]");
		}
		catch (\ErrorException $e)
		{
			throw new \XF\Db\Exception($e->getMessage());
		}

		return $connection;
	}

	/**
	 * @param array $config
	 *
	 * @return array
	 */
	protected function standardizeConfig(array $config)
	{
		return array_replace_recursive([
			'host' => 'localhost',
			'username' => '',
			'password' => '',
			'dbname' => '',
			'port' => 5432
		], $config);
	}
}