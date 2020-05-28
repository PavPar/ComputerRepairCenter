<form class="ticket" action="value-modify-data.php" method="POST">
    <h2>{TITLE}</h2>
     <table class="ticket-info__table">
                <tr class="ticket-info__row ticket-info__header">
                    <td class="ticket-info__cell" colspan="1">
                        <p> ID</p>
                    </td>
                    <td class="ticket-info__cell" colspan="1">
                        <p> Значение</p>
                    </td>
                </tr>
               {TABLE_VALS}
            </table>
    <input requiered class="ticket__input" name="value" type="text" placeholder="Значение" minlength=1>
    <button class="btn btn_type-accept" type="submit" value={VALUE} name="btn_add">Добавить значение</button>
</form>