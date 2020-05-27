const cardsBlock = document.querySelector(".cards");
const cardTemplate = document.querySelector("#card");
const navBlock = document.querySelector(".nav-block");
const btns = {
    current:navBlock.querySelector(".btn_type-current"),
    finished:navBlock.querySelector(".btn_type-finished"),
    closed:navBlock.querySelector(".btn_type-closed"),
    pool:navBlock.querySelector(".btn_type-pool"),
    all:navBlock.querySelector(".btn_type-all")
}
let cards = [] 
const allCards = userCards.concat(poolCards);
const cardFields = {
    title: ".card__title",
    date: ".card__date",
    dept: ".card__dept",
    owner: ".card__name",
    btnInfo: ".btn_type-card-info",
    btnClose: ".btn_type-card-close"
}

function fillCard(rawData) {
    let newCard = cardTemplate.cloneNode(true).content;
    newCard.querySelector(cardFields.title).textContent = `Тикет № ${rawData.id}`;
    newCard.querySelector(cardFields.date).textContent = `${rawData.date}`;
    newCard.querySelector(cardFields.dept).textContent = `Отдел : ${rawData.department}`;
    newCard.querySelector(cardFields.owner).textContent = `Заказчик : ${rawData.owner}`;
    newCard.querySelector(cardFields.btnInfo).setAttribute('value',rawData.id);
    newCard.querySelector(cardFields.btnClose).setAttribute('value',rawData.id);
    
    return newCard;
}

//TODO : ORDER
//TODO : FILTER

function displayCards(state = "in process") {
    clearCards();
    cards = [];//Очищаем текущий массив 
    allCards.forEach(cardRaw => {
        if(cardRaw.state==state){
            cards.push(fillCard(cardRaw));//Добавляем в массив новую карточку
            cardsBlock.appendChild(cards[cards.length - 1]);//!!
        }
    });
}

function clearCards(){
    cardsBlock.innerHTML="";//Очищаем все 
}

btns.current.addEventListener('click', () => {displayCards()});
btns.finished.addEventListener('click',() => displayCards("finished"));
btns.pool.addEventListener('click',() => displayCards("pool"));
btns.closed.addEventListener('click',() => displayCards("closed"));

//2020-05-19 14:34:37

// function ConvertToDateTime(rawDateTime) {
//     let DateTime = rawDateTime.Trim.split(' ');
//     let rawDate = DateTime.split('-');
//     let rawTime = DateTime.split(':')
//     let result = {
//         Date: {
//             Year: rawDate[0],
//             Month: rawDate[1],
//             Day: rawDate[2]
//         },
//         Time: {
//             Hours: rawTime[0],
//             Minutes: rawTime[1],
//             Seconds: rawTime[2]
//         }
//     }
//     return result;
// }

// function sortByDate(a, b, reverse = "false") {
//     let valA = ConvertToDateTime(a);
//     let valB = ConvertToDateTime(b);
//     if (!reverse) {//Если не reverse -> по возрастанию
//         if (valA.Date.Year >= valB.Date.Year && valA.Date.Month >= valB.Date.Month && valA.Date.Day >= valB.Date.Day) {
//             if (valA.Time.Hours > valB.Time.Hours && valA.Time.Minutes > valB.Time.Minutes && valA.Time.Seconds > valB.Time.Seconds){
//                 return -1;
//             }
//         }
//         return 1;
//     }else{
//         if (valA.Date.Year > valB.Date.Year && valA.Date.Month > valB.Date.Month && valA.Date.Day > valB.Date.Day) {
//             if (valA.Time.Hours > valB.Time.Hours && valA.Time.Minutes > valB.Time.Minutes && valA.Time.Seconds > valB.Time.Seconds){
//                 return 1;
//             }
//         }
//         return -1;
//     }
// }

displayCards();
