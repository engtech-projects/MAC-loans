<?php
ini_set('max_execution_time', 0); //unlimited
ini_set('memory_limit', '500M');

$start = microtime(true);

$pdo = connection();


$query = $pdo->query("
		SELECT loan_accounts.loan_account_id, loan_accounts.account_num, loan_accounts.branch_code, loan_accounts.loan_status, loan_accounts.due_date, (
			SELECT end_transaction.date_end FROM end_transaction WHERE end_transaction.status = 'open'
			AND end_transaction.branch_id = (SELECT branch.branch_id FROM branch WHERE branch.branch_code = loan_accounts.branch_code)) as 'date_end'
		FROM loan_accounts
		WHERE 
		loan_accounts.due_date < (
			SELECT end_transaction.date_end FROM end_transaction WHERE end_transaction.status = 'open'
			AND end_transaction.branch_id = (SELECT branch.branch_id FROM branch WHERE branch.branch_code = loan_accounts.branch_code))
		AND loan_accounts.loan_status = 'ongoing'
	");

$result = $query->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
var_export('(Ongoing) Accounts Found: '. count($result));
echo '</pre>';


$columns = array(
	'loan_status',
);

$update_data_query = 'UPDATE loan_accounts SET ';

for ($i=0; $i < count($columns) ; $i++) {

	if( ($i + 1) == count($columns)  ){
		$update_data_query .= $columns[$i].'=? ';
	}else{
		$update_data_query .= $columns[$i].'=?, ';
	}
}

$update_data_query .=  'WHERE loan_account_id = ?';

$update_data = $pdo->prepare($update_data_query);

foreach ($result as $key => $value) {
	
	$data = [
		'loan_status' => 'Past Due',
		'loan_account_id' => $value['loan_account_id'],
	];	
	
	try {
	    $pdo->beginTransaction();
        // Execute query
        if($update_data->execute(array_values($data))){
            // COMMIT
            $pdo->commit();

            echo '<pre>';
			var_export('Due date: ' . $value['due_date'] . ' | ' . ' Transaction Date: ' . $value['date_end']);
			echo '<br />';
			var_export('Account Number: <b>' . $value['account_num'] . '</b>|' . '[FROM]: ' . $value['loan_status'] . ' [TO]: Past Due');
			echo '</pre>';

        }else{
        // IF FAILED, STOP THIS SCRIPT
        die("<p>Error encountered</p>");
        }
    } catch (Exception $e) {
        echo '<pre>';
        var_export($e);
        echo '</pre>';
    } 		

}


function connection() {

	$dsn = "mysql:host=localhost;dbname=mac_data_05092023";
	$user = "root";
	$passwd = "";

	$pdo = new PDO($dsn, $user, $passwd);
	return $pdo;
}


?>