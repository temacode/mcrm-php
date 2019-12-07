var headerBtn = document.getElementById('headerBtn');
var headerMenu = document.getElementById('headerMenu');
var content = document.getElementById('content');
headerBtn.onclick = function () {
    'use strict';
    if (headerMenu.style.left === '') {
        headerMenu.style.left = ((-1) * headerMenu.offsetWidth)+'px';
    }
    if (headerMenu.style.left === ((-1) * headerMenu.offsetWidth)+'px') {
        headerMenu.style.left = '0px';
        content.style.marginLeft = '250px';
    } else {
        headerMenu.style.left = ((-1) * headerMenu.offsetWidth)+'px';
        content.style.marginLeft = '0px';
    }
};
content.onclick = function () {
    'use strict';
    headerMenu.style.left = ((-1) * headerMenu.offsetWidth)+'px';
    content.style.marginLeft = '0px';
};
var timetableButton = document.getElementById('showTimetable');
var timetableBlock = document.getElementById('timetableBlock');
timetableButton.onclick = function () {
    if (timetableBlock.style.right === '') {
        timetableBlock.style.right = '-600px';
    } 
    if (timetableBlock.style.right === '-600px') {
        timetableBlock.style.right = '-2px';
    } else {
        timetableBlock.style.right = '-600px';
    }
}

            