<form class="ticket" action="value-modify-data.php" method="POST">
    <h2>{TITLE}</h2>
    <select required class="ticket__input" name="value">
        {OPTIONS}
    </select>
    <button class="btn btn_type-accept" type="submit" value={VALUE} name="btn_del">Удалить значение</button>
</form>