<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app = new \Slim\App;
//get all the details
$app->get('/api/customers', function (Request $request, Response $response){
require 'db.php';	
$query="SELECT * FROM event_list";
$result=mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
echo json_encode($row);	
}

});

//insert value into database

$app->post('/api/customers/add', function (Request $request, Response $response){
require 'db.php';	
$event_name=$request->getParam('event_name');
$event_status=$request->getParam('event_status');
//$event_created_on=$request->getParam('event_created_on');
$event_description=$request->getParam('event_description');
$event_note=$request->getParam('event_note');
$event_type=$request->getParam('event_type');
echo $event_type;
$query="INSERT INTO event_list(event_name,event_status,event_description,event_note,event_type) VALUES($event_name,$event_status,$event_description,$event_note,$event_type)";
if(mysqli_query($con,$query)){
	echo "Added Successfully";
}
else{
	echo mysql_error();
}
});
?>