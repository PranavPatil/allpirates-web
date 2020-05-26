<?php 

// create new database (OO interface) 
$db = new SQLiteDatabase("db22.sqlite"); 

// create table foo and insert sample data 
$db->query("BEGIN; 
        CREATE TABLE foo(id INTEGER PRIMARY KEY, name CHAR(255)); 
        INSERT INTO foo (name) VALUES('Ilia'); 
        INSERT INTO foo (name) VALUES('Ilia2'); 
        INSERT INTO foo (name) VALUES('Ilia3'); 
        COMMIT;"); 

// execute a query     
$result = $db->query("SELECT * FROM foo"); 
// iterate through the retrieved rows 
while ($result->valid()) { 
    // fetch current row 
    $row = $result->current();      
    print_r($row); 
// proceed to next row 
    $result->next(); 
} 

// not generally needed as PHP will destroy the connection 
unset($db); 

?>