var equipment_array = [];

function delA(){
    //點選超連結刪除那一行
    //使用this，刪除父級元素
    var tr = this.parentNode.parentNode;
    var equipment_id = tr.id;
    var index = $.map(equipment_array, function(item, index) {  //找物件index
                return item.id;
            }).indexOf(equipment_id);
                

    equipment_array.splice(index, 1);
    console.log(equipment_array);
    document.getElementById("equipment_array").value = JSON.stringify(equipment_array);

     //獲取要刪除人員的名字
    var name=tr.getElementsByTagName("td")[0].innerHTML;
    tr.parentNode.removeChild(tr);

    //阻止瀏覽器預設行為，比如彈出新的分頁
    return false;
}


window.onload=function(){
    //點選超連結刪除一個員工資訊
    //獲取連結

    //新增員工功能,點選按鈕將資訊新增到表格中
    var add_equipment = document.getElementById("add_equipment");
    add_equipment.onclick=function(){
        //獲取輸入框中的文字內容
        var equipment_name=document.getElementById("equipment_select").text;
        var equipment_amount=parseInt(document.getElementById("equipment_amount").value);
        
        if(equipment_name && equipment_amount) {
            //檢查ID
            var equipment_id=document.getElementById("equipment_select").value;
            var index = $.map(equipment_array, function(item, index) {  //找物件index
                return item.id;
                }).indexOf(equipment_id);
            if (index == -1) {
                //放入陣列
                equipment_array.push({id:equipment_id, amount:equipment_amount});

                //建立一個tr
                var tr=document.createElement("tr");
                tr.id=equipment_id;
                //向tr中新增內容
                tr.innerHTML="<td>"+equipment_id+"</td>"+
                                "<td>"+equipment_name+"</td>"+
                                "<td>"+equipment_amount+"</td>"+
                                "<td><a href='javascript:;' class='btn btn-sm btn-danger'>"+
                                "<span class='icon'>"+
                                "<i class='fas fa-trash'></i>"+
                                "</span></a></td>";
                //debug
                console.log(equipment_array);

                var a=tr.getElementsByTagName("a")[0];
                a.onclick=delA;
                //把tr放在table中
                var equipmentList=document.getElementById("equipment_list");
                //獲取tbody
                var tbody=document.getElementsByTagName("tbody")[0];

                tbody.appendChild(tr);
            }
            else {
                //將原有物件加上當前值
                alert('項目已存在，請刪除後重新新增');
                /*equipment_array[index].amount += equipment_amount;
                console.log(equipment_array);

                var amount = document.getElementById('equipment_list').rows[index + 1].cells[2];
                amount.innerHTML= parseInt(amount.innerText) + equipment_amount;*/
            }
            //回傳equipment_array
            /*$.post("./borrowing_club.php", equipment_array).done(function(data) {
                //alert(equipment_array);
            });*/
            document.getElementById("equipment_array").value = JSON.stringify(equipment_array);
        }
        else {
            if (!equipment_name && !equipment_amount) alert('請選擇器材及輸入數量');
            else if (!equipment_name) alert('請選擇器材');
            else alert('請輸入數量');
        }
    }
}