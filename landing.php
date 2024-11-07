<?php
// Start of PHP script

// Include error reporting for development (remove or comment out in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database configuration file
include "../inc/dbinfo.inc"; // This includes your database connection constants

/* Connect to MySQL and select the database */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

/* Ensure that the EMPLOYEES table exists */
VerifyEmployeesTable($connection, DB_DATABASE);

/* If input fields are populated, add a row to the EMPLOYEES table */
$employee_name = isset($_POST['NAME']) ? htmlentities($_POST['NAME']) : '';
$employee_address = isset($_POST['ADDRESS']) ? htmlentities($_POST['ADDRESS']) : '';

if (!empty($employee_name) && !empty($employee_address)) {
    AddEmployee($connection, $employee_name, $employee_address);
}

/* Retrieve the list of employees */
$employee_list = GetEmployeeList($connection);

/* Close the database connection */
mysqli_close($connection);

/* Function to verify that the table exists, and create it if not */
function VerifyEmployeesTable($connection, $dbName)
{
    if (!TableExists("EMPLOYEES", $connection, $dbName)) {
        $query = "CREATE TABLE EMPLOYEES (
            ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            NAME VARCHAR(50) NOT NULL,
            ADDRESS VARCHAR(90) NOT NULL
        )";

        if (!mysqli_query($connection, $query)) {
            echo "<p>Error creating table: " . mysqli_error($connection) . "</p>";
        }
    }
}

/* Function to check if the table exists */
function TableExists($tableName, $connection, $dbName)
{
    $tableName = mysqli_real_escape_string($connection, $tableName);
    $dbName = mysqli_real_escape_string($connection, $dbName);

    $query = "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$tableName'";
    $result = mysqli_query($connection, $query);

    return mysqli_num_rows($result) > 0;
}

/* Function to add an employee to the table */
function AddEmployee($connection, $name, $address)
{
    // Use prepared statements for security
    $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES (?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $name, $address);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<p>Employee added successfully!</p>";
    } else {
        echo "<p>Error adding employee data: " . mysqli_error($connection) . "</p>";
    }
    mysqli_stmt_close($stmt);
}

/* Function to get the list of employees */
function GetEmployeeList($connection)
{
    $query = "SELECT ID, NAME, ADDRESS FROM EMPLOYEES";
    $result = mysqli_query($connection, $query);
    $employees = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $employees[] = $row;
        }
        mysqli_free_result($result);
    } else {
        echo "<p>Error retrieving employee data: " . mysqli_error($connection) . "</p>";
    }

    return $employees;
}
?>
<!DOCTYPE HTML>
<!--
    Forty by HTML5 UP
    html5up.net | @ajlkn
    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
    <head>
        <title>Landing - Forty by HTML5 UP</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    </head>
    <body class="is-preload">

        <!-- Wrapper -->
            <div id="wrapper">

                <!-- Header -->
                <!-- Note: The "styleN" class below should match that of the banner element. -->
                    <header id="header" class="alt style2">
                        <a href="index.html" class="logo"><strong>Forty</strong> <span>by HTML5 UP</span></a>
                        <nav>
                            <a href="#menu">Menu</a>
                        </nav>
                    </header>

                <!-- Menu -->
                    <nav id="menu">
                        <ul class="links">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="landing.html">Landing</a></li>
                            <li><a href="generic.html">Generic</a></li>
                            <li><a href="elements.html">Elements</a></li>
                        </ul>
                        <ul class="actions stacked">
                            <li><a href="#" class="button primary fit">Get Started</a></li>
                            <li><a href="#" class="button fit">Log In</a></li>
                        </ul>
                    </nav>

                <!-- Banner -->
                <!-- Note: The "styleN" class below should match that of the header element. -->
                    <section id="banner" class="style2">
                        <div class="inner">
                            <span class="image">
                                <img src="images/pic07.jpg" alt="" />
                            </span>
                            <header class="major">
                                <h1>Landing</h1>
                            </header>
                            <div class="content">
                                <p>Lorem ipsum dolor sit amet nullam consequat<br />
                                sed veroeros. tempus adipiscing nulla.</p>
                            </div>
                        </div>
                    </section>

                <!-- Main -->
                    <div id="main">

                        <!-- One -->
                            <section id="one">
                                <div class="inner">
                                    <header class="major">
                                        <h2>Sed amet aliquam</h2>
                                    </header>
                                    <p>Nullam et orci eu lorem consequat tincidunt vivamus et sagittis magna sed nunc rhoncus condimentum sem.</p>
                                </div>
                            </section>

                        <!-- Two -->
                            <section id="two" class="spotlights">
                                <section>
                                    <a href="generic.html" class="image">
                                        <img src="images/pic08.jpg" alt="" data-position="center center" />
                                    </a>
                                    <div class="content">
                                        <div class="inner">
                                            <header class="major">
                                                <h3>Orci maecenas</h3>
                                            </header>
                                            <p>Nullam et orci eu lorem consequat tincidunt vivamus et sagittis magna sed nunc rhoncus condimentum sem.</p>
                                            <ul class="actions">
                                                <li><a href="generic.html" class="button">Learn more</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <a href="generic.html" class="image">
                                        <img src="images/pic09.jpg" alt="" data-position="top center" />
                                    </a>
                                    <div class="content">
                                        <div class="inner">
                                            <header class="major">
                                                <h3>Rhoncus magna</h3>
                                            </header>
                                            <p>Nullam et orci eu lorem consequat tincidunt vivamus et sagittis magna sed nunc rhoncus condimentum sem.</p>
                                            <ul class="actions">
                                                <li><a href="generic.html" class="button">Learn more</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <a href="generic.html" class="image">
                                        <img src="images/pic10.jpg" alt="" data-position="25% 25%" />
                                    </a>
                                    <div class="content">
                                        <div class="inner">
                                            <header class="major">
                                                <h3>Sed nunc ligula</h3>
                                            </header>
                                            <p>Nullam et orci eu lorem consequat tincidunt vivamus et sagittis magna sed nunc rhoncus condimentum sem.</p>
                                            <ul class="actions">
                                                <li><a href="generic.html" class="button">Learn more</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </section>
                            </section>

                        <!-- Three -->
                            <section id="three">
                                <div class="inner">
                                    <header class="major">
                                        <h2>Massa libero</h2>
                                    </header>
                                    <p>Nullam et orci eu lorem consequat tincidunt vivamus et sagittis libero.</p>
                                    <ul class="actions">
                                        <li><a href="generic.html" class="button next">Get Started</a></li>
                                    </ul>
                                </div>
                            </section>

                    </div>

                <!-- Contact -->
                    <section id="contact">
                        <div class="inner">
                            <section>
                                <!-- Updated form -->
                                <form method="post" action="">
                                    <div class="fields">
                                        <div class="field half">
                                            <label for="NAME">Name</label>
                                            <input type="text" name="NAME" id="NAME" required />
                                        </div>
                                        <div class="field half">
                                            <label for="ADDRESS">Address</label>
                                            <input type="text" name="ADDRESS" id="ADDRESS" required />
                                        </div>
                                    </div>
                                    <ul class="actions">
                                        <li><input type="submit" value="Add Employee" class="primary" /></li>
                                        <li><input type="reset" value="Clear" /></li>
                                    </ul>
                                </form>
                            </section>
                            <!-- Employee List -->
                            <section>
                                <h2>Employee List</h2>
                                <?php if (!empty($employee_list)) { ?>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($employee_list as $employee) { ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($employee['ID']); ?></td>
                                                    <td><?php echo htmlspecialchars($employee['NAME']); ?></td>
                                                    <td><?php echo htmlspecialchars($employee['ADDRESS']); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p>No employees found.</p>
                                <?php } ?>
                            </section>
                            <section class="split">
                                <!-- Existing content -->
                                <!-- ... -->
                            </section>
                        </div>
                    </section>

                <!-- Footer -->
                    <footer id="footer">
                        <div class="inner">
                            <ul class="icons">
                                <li><a href="#" class="icon brands alt fa-twitter"><span class="label">Twitter</span></a></li>
                                <li><a href="#" class="icon brands alt fa-facebook-f"><span class="label">Facebook</span></a></li>
                                <li><a href="#" class="icon brands alt fa-instagram"><span class="label">Instagram</span></a></li>
                                <li><a href="#" class="icon brands alt fa-github"><span class="label">GitHub</span></a></li>
                                <li><a href="#" class="icon brands alt fa-linkedin-in"><span class="label">LinkedIn</span></a></li>
                            </ul>
                            <ul class="copyright">
                                <li>&copy; Untitled</li><li>Design: <a href="https://html5up.net">HTML5 UP</a></li>
                            </ul>
                        </div>
                    </footer>

            </div>

        <!-- Scripts -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/jquery.scrolly.min.js"></script>
            <script src="assets/js/jquery.scrollex.min.js"></script>
            <script src="assets/js/browser.min.js"></script>
            <script src="assets/js/breakpoints.min.js"></script>
            <script src="assets/js/util.js"></script>
            <script src="assets/js/main.js"></script>

    </body>
</html>
