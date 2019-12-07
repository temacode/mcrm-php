function newGap(id) {
  gapBlock = document.getElementById(id);
  var newDiv = document.createElement('div');
  newDiv.setAttribute('class', 'time-gap');
  var newFirst = document.createElement('p');
  var newSecond = document.createElement('p');
  newFirst.innerHTML = 'c';
  newSecond.innerHTML = 'до';
  newDiv.appendChild(newFirst);
  for (i=0;i<2;i++) {
    var newSelect = document.createElement('select');
    newSelect.setAttribute('name', id+'[]');
    if (i===1) {
      for(j=10;j<=21;j++) {
        var newOption = document.createElement('option');
        newOption.value = j;
        newOption.text = j;
        newSelect.appendChild(newOption);
      }
    } else {
      for(j=9;j<=20;j++) {
        var newOption = document.createElement('option');
        newOption.value = j;
        newOption.text = j;
        newSelect.appendChild(newOption);
      }
    }
    newDiv.appendChild(newSelect);
  }
  newDiv.insertBefore(newSecond, newSelect);
  gapBlock.appendChild(newDiv);
}