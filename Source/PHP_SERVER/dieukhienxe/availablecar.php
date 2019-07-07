<?php
	include_once 'lib/db_connect.php';

	function availablecar() {

		$json = array();

		$db = new DbConnect();

		$query = "select * from cars";

		$result = mysqli_query($db->getDb(), $query);

		if (mysqli_num_rows($result) > 0)
		{
			$i = 0;
			while ($row = mysqli_fetch_assoc($result)) {
				$id = $row['id'];
				$name = $row['name'];
				$state = $row['state'];
				$row_data = array('id'=> $id, 'name'=> $name, 'state'=>$state);
				$json['car'][$i] = $row_data;
				$i++;
			}
			$json['success'] = 1;

		}
		else {

			$json['success'] = 0;

		}

		
		mysqli_free_result($result);

		mysqli_close($db->getDb());
		
		 return $json;

	}

	if (isset($_POST['getcar']))
	{
		$response  = availablecar();
		echo json_encode($response);
	}

?>