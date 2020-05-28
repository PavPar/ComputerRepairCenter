        <div class="ticket-info">
            <table class="ticket-info__table">
                <tr class="ticket-info__row ticket-info__header">
                    <td class="ticket-info__cell" colspan="2">
                        <p> Заказ № {ID}</p>
                        <p> Состояние заказа : Завершен</p>
                        <p> Мастер выполняющий заявку : {MASTER_ID_IN}</p>
                    </td>
                </tr>
                <tr class="ticket-info__row">
                    <td class="ticket-info__cell">
                        <p> Мастер прнявший заявку : {MASTER_ID_IN}</p>
                        <p> ФИО Хозяина : {OWNER}</p>
                    </td>
                    <td class="ticket-info__cell">
                        <p> Дата приема : {DATE}</p>
                        <p> Номер телефона хозяина : {PHONE}</p>
                        <p> Отдел Хозяина: {OWNER_DEPT}</p>
                    </td>
                </tr>
                <tr class="ticket-info__row">
                    <td class="ticket-info__cell" colspan="2">
                        <p> Тип заказа : {TYPE}</p>
                        <p> Тип техники : {TECH_TYPE}</p>
                    </td>
                </tr>
                <tr class="ticket-info__row">
                    <td class="ticket-info__cell" colspan="2">
                        <p> Комментарий на момент приема: </p>
                        <p> {COMMENT_IN}</p>
                    </td>
                </tr>
                <tr class="ticket-info__row">
                    <td class="ticket-info__cell" colspan="2">
                        <p> Комментарий о проделанной работе: </p>
                        <p>{COMMENT_OUT}</p>
                    </td>
                </tr>
            </table>
        </div>