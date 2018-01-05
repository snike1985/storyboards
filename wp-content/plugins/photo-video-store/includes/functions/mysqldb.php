<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

class TMySQLConnection
{
	var $connection;

	function connect()
	{
		$this->connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	}

	function execute( $query )
	{
		if ( $mysqli_result = mysqli_query( $this->connection, $query ) )
		{
			return $mysqli_result;
		} else
		{
			return false;
		}
	}

	function close()
	{
		mysqli_close( $this->connection );
	}
}

class TMySQLQuery
{
	var $connection;
	var $result;
	var $row;
	var $trow;
	var $eof;
	var $addnew;
	var $source;
	var $rc;

	function __construct()
	{
		$this->connection = new TMySQLConnection;
	}

	function open( $query )
	{
		$this->result = $this->connection->execute( $query );
		$this->movenext();
	}

	function movenext()
	{
		if ( $this->row = @mysqli_fetch_assoc( $this->result ) )
		{
			foreach ( $this->row as $rkey => $rvalue )
			{
				$this->row[$rkey] = $rvalue;
			}

			$this->eof = false;
		} else
		{
			$this->eof = true;
		}
		$this->trow = $this->row;
		$this->rc = @mysqli_num_rows( $this->result );
	}

	function close()
	{
		$result->close();
		@mysqli_free_result( $this->result );
		unset( $this->result );
		unset( $this->connection );
	}
}

//Connection to the database
$db = new TMySQLConnection;
$rs = new TMySQLQuery;
$ds = new TMySQLQuery;
$dr = new TMySQLQuery;
$dn = new TMySQLQuery;
$dd = new TMySQLQuery;
$dq = new TMySQLQuery;

$db->connect();
$mysqli_db = $db->connection;
mysqli_query( $mysqli_db, "SET NAMES '" . DB_CHARSET . "'" );
$rs->connection = $db;
$ds->connection = $db;
$dr->connection = $db;
$dn->connection = $db;
$dd->connection = $db;
$dq->connection = $db;
?>