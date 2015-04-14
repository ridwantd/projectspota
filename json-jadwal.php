<?php

	$year = date('Y');
	$month = date('m');

	echo json_encode(array(
	
		array(
			'id' => 111,
			'title' => "Event1",
			'start' => "$year-$month-10"
		),
		
		array(
			'id' => 222,
			'title' => "Event2",
			'start' => "$year-$month-20",
			'end' => "$year-$month-22"		),

		array(
			'id' => 232,
			'title' => "Event3",
			'start' => "$year-$month-1 14:30:00",
			'allDay'=>false
		),

		array(
		 	'title'=> "Lunch with Nicole",
            'start'=> "2014-09-18T12:35:00",
            'className'=> "label-green",
            'allDay'=> false
         ),
		array(
		 	'title'=> "Lunch",
            'start'=> "2014-09-18T12:45:00",
            'allDay'=> false
         )
	
	));

?>
