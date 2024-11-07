<?php
// PHP脚本开始

// 开发过程中启用错误报告（在生产环境中请移除或注释掉）
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 包含数据库配置文件
include "../inc/dbinfo.inc"; // 这将包含您的数据库连接常量

/* 连接到MySQL并选择数据库 */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (mysqli_connect_errno()) {
    echo "连接MySQL失败: " . mysqli_connect_error();
    exit();
}

/* 确保EMPLOYEES表存在 */
VerifyEmployeesTable($connection, DB_DATABASE);

/* 如果输入字段已填充，向EMPLOYEES表添加一行 */
$employee_name = isset($_POST['NAME']) ? htmlentities($_POST['NAME']) : '';
$employee_address = isset($_POST['ADDRESS']) ? htmlentities($_POST['ADDRESS']) : '';

if (!empty($employee_name) && !empty($employee_address)) {
    AddEmployee($connection, $employee_name, $employee_address);
}

/* 检索员工列表 */
$employee_list = GetEmployeeList($connection);

/* 关闭数据库连接 */
mysqli_close($connection);

/* 函数：验证表是否存在，如不存在则创建 */
function VerifyEmployeesTable($connection, $dbName)
{
    if (!TableExists("EMPLOYEES", $connection, $dbName)) {
        $query = "CREATE TABLE EMPLOYEES (
            ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            NAME VARCHAR(50) NOT NULL,
            ADDRESS VARCHAR(90) NOT NULL
        )";

        if (!mysqli_query($connection, $query)) {
            echo "<p>创建表时出错: " . mysqli_error($connection) . "</p>";
        }
    }
}

/* 函数：检查表是否存在 */
function TableExists($tableName, $connection, $dbName)
{
    $tableName = mysqli_real_escape_string($connection, $tableName);
    $dbName = mysqli_real_escape_string($connection, $dbName);

    $query = "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$tableName'";
    $result = mysqli_query($connection, $query);

    return mysqli_num_rows($result) > 0;
}

/* 函数：向表中添加员工 */
function AddEmployee($connection, $name, $address)
{
    // 使用预处理语句以提高安全性
    $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES (?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $name, $address);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<p>员工添加成功！</p>";
    } else {
        echo "<p>添加员工数据时出错: " . mysqli_error($connection) . "</p>";
    }
    mysqli_stmt_close($stmt);
}

/* 函数：获取员工列表 */
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
        echo "<p>检索员工数据时出错: " . mysqli_error($connection) . "</p>";
    }

    return $employees;
}
?>
<!DOCTYPE HTML>
<!--
    Forty by HTML5 UP
    html5up.net | @ajlkn
    根据CCA 3.0许可证（html5up.net/license）免费用于个人和商业用途
-->
<html>
    <head>
        <title>登陆页 - Forty by HTML5 UP</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    </head>
    <body class="is-preload">

        <!-- 包装器 -->
            <div id="wrapper">

                <!-- 头部 -->
                <!-- 注意：下面的“styleN”类应与横幅元素的类匹配。 -->
                    <header id="header" class="alt style2">
                        <a href="index.html" class="logo"><strong>Forty</strong> <span>by HTML5 UP</span></a>
                        <nav>
                            <a href="#menu">菜单</a>
                        </nav>
                    </header>

                <!-- 菜单 -->
                    <nav id="menu">
                        <ul class="links">
                            <li><a href="index.html">主页</a></li>
                            <li><a href="landing.html">登陆页</a></li>
                            <li><a href="generic.html">通用页</a></li>
                            <li><a href="elements.html">元素页</a></li>
                        </ul>
                        <ul class="actions stacked">
                            <li><a href="#" class="button primary fit">开始</a></li>
                            <li><a href="#" class="button fit">登录</a></li>
                        </ul>
                    </nav>

                <!-- 横幅 -->
                <!-- 注意：下面的“styleN”类应与头部元素的类匹配。 -->
                    <section id="banner" class="style2">
                        <div class="inner">
                            <span class="image">
                                <img src="images/pic07.jpg" alt="" />
                            </span>
                            <header class="major">
                                <h1>登陆页</h1>
                            </header>
                            <div class="content">
                                <p>欢迎来到我们的登陆页<br />
                                请随意浏览。</p>
                            </div>
                        </div>
                    </section>

                <!-- 主体 -->
                    <div id="main">

                        <!-- 第一部分 -->
                            <section id="one">
                                <div class="inner">
                                    <header class="major">
                                        <h2>关于我们</h2>
                                    </header>
                                    <p>我们致力于提供最优质的服务，满足您的需求。我们的团队由经验丰富的专业人士组成，确保为您提供最佳的解决方案。</p>
                                </div>
                            </section>

                        <!-- 第二部分 -->
                            <section id="two" class="spotlights">
                                <section>
                                    <a href="generic.html" class="image">
                                        <img src="images/pic08.jpg" alt="" data-position="center center" />
                                    </a>
                                    <div class="content">
                                        <div class="inner">
                                            <header class="major">
                                                <h3>我们的服务</h3>
                                            </header>
                                            <p>我们提供广泛的服务，以满足各种需求。无论您需要什么，我们都能为您提供定制的解决方案。</p>
                                            <ul class="actions">
                                                <li><a href="generic.html" class="button">了解更多</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </section>
                              
                            </section>

                       

                    </div>

                <!-- 联系我们 -->
                    <section id="contact">
                        <div class="inner">
                            <section>
                                <!-- 更新的表单 -->
                                <form method="post" action="">
                                    <div class="fields">
                                        <div class="field half">
                                            <label for="NAME">姓名</label>
                                            <input type="text" name="NAME" id="NAME" required />
                                        </div>
                                        <div class="field half">
                                            <label for="ADDRESS">地址</label>
                                            <input type="text" name="ADDRESS" id="ADDRESS" required />
                                        </div>
                                    </div>
                                    <ul class="actions">
                                        <li><input type="submit" value="添加员工" class="primary" /></li>
                                        <li><input type="reset" value="清除" /></li>
                                    </ul>
                                </form>
                            </section>
                            <!-- 员工列表 -->
                            <section>
                                <h2>员工列表</h2>
                                <?php if (!empty($employee_list)) { ?>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>姓名</th>
                                                <th>地址</th>
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
                                    <p>未找到任何员工。</p>
                                <?php } ?>
                            </section>
                            <section class="split">
                                <!-- 现有内容 -->
                                <!-- ... -->
                            </section>
                        </div>
                    </section>

                <!-- 页脚 -->
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
                                <li>&copy; 未命名</li><li>设计: <a href="https://html5up.net">HTML5 UP</a></li>
                            </ul>
                        </div>
                    </footer>

            </div>

        <!-- 脚本 -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/jquery.scrolly.min.js"></script>
            <script src="assets/js/jquery.scrollex.min.js"></script>
            <script src="assets/js/browser.min.js"></script>
            <script src="assets/js/breakpoints.min.js"></script>
            <script src="assets/js/util.js"></script>
            <script src="assets/js/main.js"></script>

    </body>
</html>
