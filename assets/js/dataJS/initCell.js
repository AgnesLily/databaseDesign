var region = 5;
var areas = [];//某区域教室名
initArea(region);//默认加载5区
var areaData = [];//classroom表里的内容
var cellData = [];//time表里的内容

$(".area-option").change(function(){
	var op = $(this).children('option:selected').val();
	region = op;
	initArea(op);
});

//得到该区的教室名称
function initArea(option){
	var _data = {
		"option":option
	};
	$.ajax({
		type:"post", 
		url:"interface/cell/cellArea.php",
		async:true,
		data:_data,
		dataType:'json',
		success:function(data) {
			areaData = data;
			handleHours(data);
		}
	});
}

function handleHours(data) {
	for(var i = 0;i < data.length;i++){
		areas.push(data[i].cname);
	}
	
	initData();
}

//按区域和日期得到具体的数据值
function initData() {
	var _data = {
		'region':region,
		'date':"2016-09-20"
	};
	
	$.ajax({
		type:"post",
		url:"interface/cell/cellData.php",
		async:true,
		data:_data,
		dataType:'json',
		success:function(data) {
			cellData = data;
			console.log(data);
			initCell();
//			consoleDa();//得到数据库中的某天的数据
		}
	});
}


//initCell();
function initCell(){
	var myChart = echarts.init(document.getElementById('con'));

	// 指定图表的配置项和数据
	var days = ['21:00', '20:00', '19:00',
		        '18:00', '17:00', '16:00', '15:00',
		        '14:00', '13:00', '12:00', '11:00',
		        '10:00', '09:00', '08:00'];//14
//	
//	var item = [];
//	var data = [];			
//	var index = 0;
//	consoleData();
//	function consoleData() {				    
//		for(var i = 0; i < 14; i++){
//			item[i] = new Array();
//			for(var j = 0;j < areaData.length;j++){
//				(function(){
//			        var z = parseInt(3*Math.random());
//	//							var z = 1;
//					item[i][j] = new Array();
//					item[i][j] = [i,j,z];
//					if(index < 240){
//						data[index] = new Array();
//						data[index] = item[i][j];
//						index++;
//					}
//			    })();							
//			}	
//		}
//	}
	var data = [];	
	var cell = [];
	var cells = [];
	consoleData();
	function consoleData() {
//		var iter = 0;
		for(var i = 0;i < areaData.length;i++) {//按每个教室来划分
			for(var j = 0;j < cellData.length;j++){
//				console.log(i);//找到教室相对的数据
				if(areaData[i].cid == cellData[j].cid) {
//					iter = i;//教室与数据对应起来
					for(var index = 0;index < 14; index++){//填充数据
						var a = 21 - index;
						var z = cellData[j]['time_'+ a];
						if(z == 3){
							z = 0;
						}
//						console.log(z);
						z = parseInt(z);
						cell  = [index , i , z];
						cells.push(cell);
//						console.log(cell);
//						cells[iter] = cell;
//						iter = iter + areaData.length;
					}	
					break;
				}
			}
		}
//		console.log();
		data = cells;
	}
	
//	console.log(data);
	
	cells = cells.map(function (item) {
	    return [item[1], item[0], item[2] || '-'];
	});

	option = {
	    tooltip: {
	        position: 'top'
	    },
	    animation: false,
	    grid: {
	        height: '50%',
	        y: '10%'
	    },
	    xAxis: {
	        type: 'category',
	        data: areas,
	        splitArea: {
	            show: true
	        },
	        nameLocation:'start',
	        gridIndex: 0,
	        axisLabel : {
	            show:true,
	            interval: 0//,    // {number}
	            //rotate: 45,
	           // margin: 8
	           
	    	}
	    },
	    yAxis: {
	        type: 'category',
	        data: days,
	        splitArea: {
	            show: true
	        }
	    },
	    visualMap: {
	        min: 0,
	        max: 4,
	        calculable: true,
	        orient: 'horizontal',
	        left: 'center',
	        top: '65%'
	    },
	    series: [{
	        name: 'Punch Card',
	        type: 'heatmap',
	        data: cells,
	        label: {
	            normal: {
	//	    show: true
	            }
	        },
	        itemStyle: {
	            emphasis: {
	                shadowBlur: 10,
	                shadowColor: 'rgba(0, 0, 0, 0.5)'
	            }
	        }
	    }],
	     dataZoom: [
	        {
	            show: true,
	            realtime: true,
	            start: 0,
	            end: 40,
	            bottom: 80
	        }
	    ],
	    color:"#ccc"
	};
	
	// 使用刚指定的配置项和数据显示图表。
	myChart.setOption(option);
	window.onresize = myChart.resize;
}

