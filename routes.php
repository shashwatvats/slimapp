<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app = new \Slim\App;
//get all the details

$app->get('/api/customers', function(Request $request, Response $response){
    $sql = "SELECT * FROM event_list";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//insert values using mysqli query

$app->get('/api/customers/get', function (Request $request, Response $response){
 require 'db2.php';	
$query="SELECT * FROM event_list";
$result=mysqli_query($con,$query);
if (mysqli_num_rows($result)>0) {
while($row = mysqli_fetch_assoc($result)){
echo json_encode($row);	
}	
}
});

//insert value into database

$app->post('/api/customers/add', function (Request $request, Response $response){
	$event_name = $request->getParam('event_name');
    $event_status = $request->getParam('event_status');
    $event_description = $request->getParam('event_description');
    $event_note = $request->getParam('event_note');
    $event_type = $request->getParam('event_type');
    $sql = "INSERT INTO event_list (event_name,event_status,event_description,event_note,event_type) VALUES
    (:event_name,:event_status,:event_description,:event_note,:event_type)";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':event_name', $event_name);
        $stmt->bindParam(':event_status',  $event_status);
        $stmt->bindParam(':event_description', $event_description);
        $stmt->bindParam(':event_note',      $event_note);
        $stmt->bindParam(':event_type',    $event_type);
        $stmt->execute();
        echo 'Customer Added';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Update Customer
$app->put('/api/customers/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $event_name = $request->getParam('event_name');
    $event_status = $request->getParam('event_status');
    $event_description = $request->getParam('event_description');
    $event_note = $request->getParam('event_note');
    $event_type = $request->getParam('event_type');
    $sql = "UPDATE event_list SET
				event_name 	= :event_name,
				event_status 	= :event_status,
                event_description		= :event_description,
                event_note		= :event_note,
                event_type 	= :event_type
			WHERE event_id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':event_name', $event_name);
        $stmt->bindParam(':event_status',  $event_status);
        $stmt->bindParam(':event_description', $event_description);
        $stmt->bindParam(':event_note',      $event_note);
        $stmt->bindParam(':event_type',    $event_type);
        $stmt->execute();
        echo 'Customer Updated';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Delete Customer
$app->delete('/api/customers/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM event_list WHERE event_id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo 'Customer Deleted';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

?>