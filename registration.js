function buildTable(){
    var input, filter, table, tr, td, i, text;
    input=document.getElement("myInput");
    filter= input.value.toUpperCase();
    table= document.getElementById("myTable");
    tr=table .getElementsByTagName("tr"); 
