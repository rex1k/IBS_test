<?php

/** @var $APPLICATION CMain */

?>

<form action="<?= $APPLICATION->GetCurPage(); ?>" method="post">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="step" value="2">
    <input type="hidden" name="lang" value="ru">
    <input type="hidden" name="id" value="kmaruniak.test">
    <input type="hidden" name="install" value="Y">
    <table>
        <tr>
            <td>
                <input type="checkbox" name="drop" id="drop" value="Y">
            </td>
            <td>
                <label for="drop">Удалить ранее созданные таблицы, если они существуют, и создать заново</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="fill" id="fill" value="Y">
            </td>
            <td>
                <label for="fill">Добавить тестовые данные</label>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
            <input type="submit" value="Продолжить">
            </td>
        </tr>
    </table>
</form>

<?php