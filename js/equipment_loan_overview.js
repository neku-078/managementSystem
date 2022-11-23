var DateDiff = function (sDate1, sDate2) { // sDate1 和 sDate2 是 2016-06-18 格式
	var oDate1 = new Date(sDate1);
	var oDate2 = new Date(sDate2);
	var iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24); // 把相差的毫秒數轉換為天數
	return iDays;
};

gantt.config.columns = [
	    {name:"text", label:"器材", width:"*", tree:true },
	    {name:"add", label:"", width:44 }
];
/*計算日期差*/
/*
var start = new Date(匯入領取日期);
var end = new Date(匯入歸還日期);
var duration_dates = end.getTime() - start.gewtTime();

然後下面的start_date: start, duration: duration_dates
這邊每項要單獨處理, 用loop
*/
var equipment_array = {data:[]};
var a = [{id: 1, text: "音箱（1）", type: "project", render:"split", parent: 0}, {id: 2, text: "展版222", type: "project", render:"split", parent: 0}];
var taskList = {
	data: [
		{id: 1, text: "音箱（藍）", type: "project", render:"split", parent: 0},
			{id: 10, text: "吉他社", start_date: "2018-12-15 12:00", duration: 1, 
			    parent: 1},
			{id: 11, text: "熱舞社", start_date: "2018-12-17 12:00", duration: 1, 
			    parent: 1},
			{id: 12, text: "學生會", start_date: "2018-12-18 12:00", duration: 5, 
			    parent: 1},

	    {id: 2, text: "展版", type: "project", render:"split", parent: 0},

		{id: 3, text: "會議桌", type: "project", open: true, parent: 0},  
			{id: 30, text: "(1)", render:"split", parent: 3},
		    	{id: 301, text: "原霸社", start_date: "2018-12-20 12:00", duration: 5, 
		    		parent: 30},
			{id: 31, text: "(2)", render:"split", parent: 3},
		    	{id: 311, text: "海鷗社", start_date: "2018-12-20 12:00", duration: 2,
		    		parent: 31},
			{id: 32, text: "(3)", render:"split", parent: 3},
			    {id: 321, text: "資工系學會", start_date: "2018-12-22 12:00", duration: 20,
					parent: 32}
	]
};
var today = new Date();
for (var i = 0; i < equipment_data.length; i++) {
	equipment_array["data"].push({id: i + 1, text: equipment_data[i][1], type: "project", render:"split", parent: 0});
	equipment_array["data"].push({id: (i+1)*10 + 1, text: equipment_data[i][1], start_date: new Date(today.getFullYear(), today.getMonth(), today.getDay()), duration: 0, parent: i+1});
}
/*var index = $.map(equipment_data, function(item, index) {
		return item[0];
	}).indexOf(borrow_data[0][4]);*/
for (var i = 0; i < borrow_data.length; i++) {
	if(new Date(borrow_data[i][3]) >= new Date(today.getFullYear(), today.getMonth(), today.getDay())) {
		var index = $.map(equipment_data, function(item, index) {
			return item[0];
		}).indexOf(borrow_data[i][4]);
		duration_dates = DateDiff(borrow_data[i][2], borrow_data[i][3]);
		equipment_array["data"].push({id: index * 10 + i + 2, text: borrow_data[i][1], start_date: new Date(borrow_data[i][2]).toISOString().split('T')[0] + " 12:00", duration: duration_dates, parent: index + 1});
	}
}
gantt.config.start_date = new Date(today.getFullYear(), today.getMonth(), today.getDay()+1);
gantt.config.end_date = new Date(today.getFullYear(), today.getMonth()+2, today.getDay()+1);
/*gantt.config.start_date = new Date(2022, 00, 01);
gantt.config.end_date = new Date(2022, 03, 01);*/
gantt.config.date_format = "%Y-%m-%d %H:%i";
gantt.config.readonly = true;
gantt.init("gantt_here");
gantt.parse(equipment_array);