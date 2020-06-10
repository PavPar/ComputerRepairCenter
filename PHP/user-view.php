<?php include "db.php"?>
<?php userAuthCheck();?>
<?php checkPrivalge()?>
<!DOCTYPE html>
<html lang="ru">

<?php
function createHeader()
{
    require_once 'template.php';
    $parse = new parse_class;
    if (userCheck()) {
        if (checkPrivalge()) {
            $parse->get_tpl('index__header-admin.tpl');
            $parse->set_tpl('{LOGIN}', getUserData()['login']);
        } else {
            $parse->get_tpl('index__header-master.tpl');
            $parse->set_tpl('{LOGIN}', getUserData()['login']);
        }

    } else {
        echo "Auth error!";
        return;
    }
    $parse->tpl_parse();
    echo $parse->template;
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASTER PAGE</title>
    <link href="../pages/ticket__create.css" rel="stylesheet">
</head>

<body class="page">
   <?php createHeader();?>
    <main class="content">
    <form class="ticket" >
    <table class="ticket-info__table">
                <tr class="ticket-info__row ticket-info__header">
                    <td class="ticket-info__cell" colspan="1">
                        <p> ID</p>
                    </td>
                    <td class="ticket-info__cell" colspan="3">
                        <p> ФИО</p>
                    </td>
                    <td class="ticket-info__cell" colspan="1">
                        <p> Логин</p>
                    </td>
                    <td class="ticket-info__cell" colspan="1">
                        <p> Пароль</p>
                    </td>
                </tr>
               <?php echo getUserRows(); ?>
    </table>
        </form>
    </main>
    <footer class="footer"></footer>
</body>

</html>
