<?php
function createEmail($name, $lastname)
{
    $email = $name.".".$lastname."@upr.edu";
    $email = str_replace(" ", "", $email);
    return $email;
}
#require "connection.php";
$hostname = "localhost";
$username = "hallyma.gauthier";
$pswd = "801912923";
$database = "laboratorio";

try {
    $connection = mysqli_connect( $hostname, $username, $pswd, $database);
}
catch (Exception $exception) {
    print("Error connecting to database: ". $exception->getMessage()) and die();
}
$query = "select * from estudiantesc12";
$statement = mysqli_prepare($connection, $query);
mysqli_stmt_execute($statement);
#mysqli_bind_result($statement, $id, $nombres, $apellidos);
$results= mysqli_stmt_get_result($statement);
$total_rows=mysqli_stmt_affected_rows($statement);
mysqli_stmt_close($statement);
?>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding-top: 8px;
            padding-right: 8px;
            padding-bottom: 8px;
            padding-left: 8px;
        }
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    <title></title>
</head>

<body>
<table>

    <tr>
        <th>
            ID
        </th>
        <th>
            NAME
        </th>
        <th>
            LASTNAME
        </th>
        <th>
            EMAIL
        </th>
    </tr>

    <?php
    while ($data = mysqli_fetch_array($results)) {
        print "<tr>";
        print "<td>";
        print $data[0];
        print "</td>" ;
        print  "<td>" ;
        print ucwords(strtolower($data[1])) ;
        print "</td>";
        print "<td>";
        print ucwords(strtolower($data[2]), " -") ;
        print "</td>";
        print "<td>";
        $names=strtolower($data[1]);
        $lastnames=strtolower($data[2]);
        $space = strpos($names," ");
        if ($space===false) {
            $name = $names;
        }
        else {
            $name = substr($names, 0, $space);
        }
        $dash = strpos( $lastnames, "-");
        if($dash===false) {
            $lastname = $lastnames;
        }
        else {
            $lastname = substr($lastnames, 0, $dash);
        }
        $email = createEmail($name, $lastname);
        print '<a target="_blank" href="mailto:'.$email.'">'.$email."</a>";
        print "</td>";
        print "</tr> \n " ;
    }
    ?>
</table>
</body>
</html>
