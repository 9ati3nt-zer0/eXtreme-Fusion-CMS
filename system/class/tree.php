<?php
/***********************************************************
| eXtreme-Fusion 5.0 Beta 5
| Content Management System
|
| Copyright (c) 2005-2012 eXtreme-Fusion Crew
| http://extreme-fusion.org/
|
| This product is licensed under the BSD License.
| http://extreme-fusion.org/ef5/license/
***********************************************************/
class Tree
{
	// Database object
	protected $_pdo;

	// Name of data table
	protected $table;

	public function __construct($_pdo, $table)
	{
		$this->_pdo = $_pdo;

		$table = new Edit($table);
		$this->table = $table->strip();
	}

	public function get($id)
	{
		if (isNum($id))
		{
			$row = $this->_pdo->getRow('SELECT `left`, `right` FROM ['.$this->table.'] WHERE id = :id', array(':id', $id, PDO::PARAM_INT));

			$data = $this->_pdo->getData('SELECT `name`, `right`, `left` FROM ['.$this->table.'] WHERE `left` BETWEEN '.$row['left'].' AND `right` ORDER BY `left`');

			$right = NULL; $z = NULL; $i = 0;
			$elem = array();

			foreach($data as $r)
			{
				$elem[$i]['name'] = $r['name'];

				if ($right && $r['right'] < $right)
				{
					$z = $right;
					$elem[$i]['new'] = TRUE;
				}
				elseif ($z && $r['right'] > $z)
				{
					$elem[$i]['end'] = TRUE;
				}

				$right = $r['right'];
				$i++;
			}

			return $elem;
		}

		return FALSE;
	}

	public function delete($id, $del_sub = FALSE)
	{
		if (isNum($id))
		{
			if ($data = $this->_pdo->getRow('SELECT `left`, `right` FROM ['.$this->table.'] WHERE id = :id', array('id', $id, PDO::PARAM_INT)))
			{
				if ($del_sub)
				{
					// Ilośc elementów podzbioru
					$count = ($data['right']-$data['left']-1);

					// Przesunięcie left/right pozostałych elementów
					$order = $count + 2;

					$this->_pdo->exec('DELETE FROM ['.$this->table.'] WHERE `left` BETWEEN '.$data['left'].' AND '.$data['right'].' OR `id` = '.$id);

					$this->_pdo->exec('UPDATE ['.$this->table.'] SET `left` = `left`-'.$order.', `right` = `right`-'.$order.' WHERE `right` > '.$data['right'].' AND `left` > '.$data['left']);

					$this->_pdo->exec('UPDATE ['.$this->table.'] SET `right` = `right`-'.$order.' WHERE `right` > '.$data['right'].' AND `left` < '.$data['left']);

				}
				else
				{
					$this->_pdo->exec('UPDATE ['.$this->table.'] SET `left` = `left`-1, `right` = `right`-1 WHERE `left` > '.$data['left'].' AND `right` < '.$data['right']);

					$this->_pdo->exec('UPDATE ['.$this->table.'] SET `left` = `left`-2 WHERE `right` > '.$data['right'].' AND `left` > '.$data['left']);
					$this->_pdo->exec('UPDATE ['.$this->table.'] SET `right` = `right`-2 WHERE `right` > '.$data['right']);


				}

				$this->_pdo->exec('DELETE FROM ['.$this->table.'] WHERE `id` = '.$id);

				return TRUE;
			}
		}

		return FALSE;
	}

	// Sadzenie nowego drzewka w ogrodzie
	protected function create($order = NULL)
	{
		if ($data = $this->_pdo->getData('SELECT `left`, `right` FROM ['.$this->table.']'))
		{
			$order = intval($order);

			$max_right = 0; $i = 1;
			foreach($data as $row)
			{
				if ($row['right'] > $max_right)
				{
					$max_right = $row['right'];
				}
				else
				{
					continue;
				}

				if ($i === $order)
				{
					$new_left = $row['left'];
					break;
				}

				$i++;
			}

			if (!isset($new_left))
			{
				return $this->_pdo->exec('INSERT INTO ['.$this->table.'] (`left`, `right`) VALUES ('.($max_right+1).', '.($max_right+2).')');
			}
			else
			{
				$this->_pdo->exec('UPDATE ['.$this->table.'] SET `left` = `left`+2, `right` = `right`+2 WHERE `left` >= '.$new_left);
				return $this->_pdo->exec('INSERT INTO ['.$this->table.'] (`left`, `right`) VALUES ('.($new_left).', '.($new_left+1).')');
			}
		}
		else
		{
			return $this->_pdo->exec('INSERT INTO ['.$this->table.'] (`left`, `right`) VALUES (1, 2)');
		}
	}

	// Dodawanie elementu do ogrodu: sadzenie drzewka lub nowy liść
	public function add($id, $order = NULL)
	{

		if (isNum($id, TRUE, FALSE))
		{
			// NOWE DRZEWKO:

			if (intval($id) === 0)
			{
				return $this->create($order);
			}

			// NOWY LIŚĆ:

			if ($data = $this->_pdo->getRow('SELECT `left`, `right` FROM ['.$this->table.'] WHERE `id` = '.$id))
			{
				if ($order && isNum($order))
				{
					if ($sub = $this->_pdo->getData('SELECT `left`, `right` FROM ['.$this->table.'] WHERE `left` BETWEEN '.($data['left']+1).' AND '.($data['right']-1).' ORDER BY `left`'))
					{

						$i = 1; $last = 0;
						// Wychwytywanie elementu, który obecnie zajmuje pozycję $order
						foreach($sub as $val)
						{

							// Zapisywanie maksymalnej wartości `right`. W przypadku gdyby żaden element nie był na pozycji $order,
							// nowy rekord znajdzie się na końcu poziomu, a jego `left` wyniesie $last+1.
							if ($val['right'] > $last)
							{
								$last = $val['right'];
							} else continue;

							if ($i == $order)
							{
								$left = $val['left'];
								break;
							}

							$i++;


						}
					}

					if (!isset($left))
					{
						$left = $last+1;
					}

				}
				else
				{
					$left = $data['left']+1;
				}

				$this->_pdo->exec('UPDATE ['.$this->table.'] SET `left` = `left`+2, `right` = `right`+2 WHERE `left` >= '.$left);
				$this->_pdo->exec('UPDATE ['.$this->table.'] SET `right` = `right`+2 WHERE `left` <= '.$data['left'].' AND `right` >= '.$data['right']);

				return $this->_pdo->exec('INSERT INTO ['.$this->table.'] (`left`, `right`) VALUES ('.($left).', '.($left+1).')');
			}
		}

		return FALSE;
	}

	/* depr
	protected function addOrder($id, $order)
	{
		if (isNum($id))
		{
			if ($data = $this->_pdo->getRow('SELECT `left`, `right` FROM ['.$this->table.'] WHERE `id` = '.$id))
			{
				if ($sub = $this->_pdo->getData('SELECT `left`, `right` FROM ['.$this->table.'] WHERE `left` BETWEEN '.($data['left']+1).' AND '.($data['right']-1)))
				{
					$i = 1;
					foreach($sub as $val)
					{
						if ($i == $order)
						{
							$left = $val['left'];

							break;
						}
						$i++;
					}
				}

				if (!isset($left))
				{
					$left = $data['left']+1;
				}

				$this->_pdo->exec('UPDATE ['.$this->table.'] SET `left` = `left`+2, `right` = `right`+2 WHERE `left` >= '.$left);
				$this->_pdo->exec('UPDATE ['.$this->table.'] SET `right` = `right`+2 WHERE `left` <= '.$data['left'].' AND `right` >= '.$data['right']);

				$this->_pdo->exec('INSERT INTO ['.$this->table.'] (`left`, `right`) VALUES ('.($left).', '.($left+1).')');
			}
		}

		return FALSE;
	}*/
}