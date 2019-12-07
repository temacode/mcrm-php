function showForm(data) {
    editBlock = document.getElementsByClassName('order-info');
    for (i=0;i<editBlock.length;i++) {
        editBlock[i].style.display = 'none';
    }
    document.getElementById('id'+data).style.display = 'block';
}