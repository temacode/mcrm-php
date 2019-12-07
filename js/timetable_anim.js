var date = new Date();
var day = document.getElementById('day');
var month = document.getElementById('month');
var year = document.getElementById('year');
for (i=1;i<=31;i++) {
    if (i===date.getDate()) {
        day.innerHTML += '<option selected value="'+i+'">'+i+'</option>';
    } else {
        day.innerHTML += '<option value="'+i+'">'+i+'</option>';    
    }
}
for (i=1;i<=12;i++) {
    switch (i) {
        case 1:
            var monthName = 'Январь';
            break;
        case 2:
            var monthName = 'Февраль';
            break;
        case 3: 
            var monthName = 'Март';
            break;
        case 4:
            var monthName = 'Апрель';
            break;
        case 5:
            var monthName = 'Май';
            break;
        case 6:
            var monthName = 'Июнь';
            break;
        case 7:
            var monthName = 'Июль';
            break;
        case 8:
            var monthName = 'Август';
            break;
        case 9:
            var monthName = 'Сентябрь';
            break;
        case 10:
            var monthName = 'Октябрь';
            break;
        case 11:
            var monthName = 'Ноябрь';
            break;
        case 12:
            var monthName = 'Декабрь';
            break;
    }
    if (i===date.getMonth()+1) {
        month.innerHTML += '<option selected value="'+i+'">'+monthName+'</option>';
    } else {
        month.innerHTML += '<option value="'+i+'">'+monthName+'</option>';    
    }
}
for (i=(date.getFullYear()-1);i<(date.getFullYear()+2);i++) {
    if (i===date.getFullYear()) {
        year.innerHTML += '<option selected value="'+i+'">'+i+'</option>';
    } else {
        year.innerHTML += '<option value="'+i+'">'+i+'</option>';    
    }
}
function showSelect() {
    var selectFirst = document.getElementById('first');
    var selectSecond = document.getElementById('second');
    var i;
    var time = "";
    for (i = 9; i <= 21; i++) {
        if (length.i === 1) {
            time = "0"+i+":00";
        } else {
            time = i+":00";
        }
        selectFirst.innerHTML += "<option value=\""+i+"\">"+time+"</option>";
    }
    for (i = 9; i <= 21; i++) {
        if (length.i === 1) {
            time = "0"+(i+1)+":00";
        } else {
            time = (i+1)+":00";
        }
        selectSecond.innerHTML += "<option value=\""+(i+1)+"\">"+time+"</option>";
    }
    selectFirst.onchange = function() {
        selectSecond.innerHTML = " ";
        for (i=Number(selectFirst.value);i<=21;i++) {
            if (length.i === 1) {
                time = "0"+(i+1)+":00";
            } else {
                time = (i+1)+":00";
            }
            selectSecond.innerHTML += "<option value=\""+(i+1)+"\">"+time+"</option>";
        } 
    }
}
showSelect();
var closeBtn = document.getElementById('closeBtn');
closeBtn.onclick = function showDeliveryChange(id) {
    var block = document.getElementById('timetableChangeBlock');
    var input = document.getElementById('orderNum');
    if (block.style.left === '') {
        block.style.left = '100%';
    }
    if (block.style.left === '100%') {
        block.style.left = '25%';
        input.value = id;
    } else {
        block.style.left = '100%';
        input.value = '';
    }
}
function showDeliveryChange(id) {
    var block = document.getElementById('timetableChangeBlock');
    var input = document.getElementById('orderNum');
    if (block.style.left === '') {
        block.style.left = '100%';
    }
    if (block.style.left === '100%') {
        block.style.left = ((100-(block.clientWidth)/(window.innerWidth/100))/2)+'%';
        input.value = id;
    } else {
        block.style.left = ((100-(block.clientWidth)/(window.innerWidth/100))/2);
    }
}