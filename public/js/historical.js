"use strict";

class History {
    constructor() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        this.bindEvenet();
    }

    bindEvenet() {
        $(document).on('click','.upload-form',()=> {
            History.getData();
            History.getData_FB()
            History.uploaded_history()
        })
    }

    static getData(){
        $.ajax({
            method: 'POST',
            url: '/getHistoricalData',
            data: {},
            success:function(r){
		        History.serChart(JSON.parse(r))
            }    
        })
    }

        static getData_FB(){
        $.ajax({
            method: 'POST',
            url: '/getHistoricalData_FB',
            data: {},
            success:function(r){
                console.log(r);
                History.serChart_FB(JSON.parse(r))
                console.log(JSON.parse(r))
            }    
        })
    }

        static uploaded_history(){
        $.ajax({
            method: 'POST',
            url: '/uploaded_history',
            data: {},
            success:function(r){
                console.log(r);
                History.create_table(JSON.parse(r))
            }    
        })
    }
    static serChart(data) {
        var ctx=$("#bar-stacked");
        var chartOptions={responsive:true,maintainAspectRatio:false,legend:{position:'bottom',},hover:{mode:'label'},scales:{xAxes:[{display:true,gridLines:{color:"#f3f3f3",drawTicks:false,},scaleLabel:{display:true,labelString:'Time during the day'},ticks:{padding:15}}],yAxes:[{display:true,gridLines:{color:"#f3f3f3",drawTicks:false,},scaleLabel:{display:true,labelString:'Number'},ticks:{padding:15}}]},title:{display:true,text:'Twitter messages and tweets during the day'}};
        
        var colors_array=['#00A5A8','#FF7D4D','#0ea09b','#058241','#99ffb7','#edc4a3','#ed5562'];
        



        var chartData={
            labels:["0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"],
            datasets:[{label:"Messages",
            data:data.count_messages,fill:false,borderColor:"#9C27B0",pointBorderColor:"#9C27B0",pointBackgroundColor:"#FFF",pointBorderWidth:1,pointHoverBorderWidth:1,pointRadius:3,},{label:"Tweets",
            data:data.count_tweets,fill:false,borderColor:"#00A5A8",pointBorderColor:"#00A5A8",pointBackgroundColor:"#FFF",pointBorderWidth:1,pointHoverBorderWidth:1,pointRadius:3,}]};
        var config={type:'line',options:chartOptions,data:chartData};
        var lineChart=new Chart(ctx,config);


    }

        static serChart_FB(data) {
        var ctx=$("#bar-stacked-FB");
        var chartOptions={responsive:true,maintainAspectRatio:false,legend:{position:'bottom',},hover:{mode:'label'},scales:{xAxes:[{display:true,gridLines:{color:"#f3f3f3",drawTicks:false,},scaleLabel:{display:true,labelString:'Time during the day'},ticks:{padding:15}}],yAxes:[{display:true,gridLines:{color:"#f3f3f3",drawTicks:false,},scaleLabel:{display:true,labelString:'Number'},ticks:{padding:15}}]},title:{display:true,text:'Facebook comments and posts during the day'}};
        
        var colors_array=['#00A5A8','#FF7D4D','#0ea09b','#058241','#99ffb7','#edc4a3','#ed5562'];
        



        var chartData={
            labels:["0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"],
            datasets:[{label:"Comments",
            data:data.count_comments,fill:false,borderColor:"#9C27B0",pointBorderColor:"#9C27B0",pointBackgroundColor:"#FFF",pointBorderWidth:1,pointHoverBorderWidth:1,pointRadius:3,},{label:"Posts",
            data:data.count_posts,fill:false,borderColor:"#00A5A8",pointBorderColor:"#00A5A8",pointBackgroundColor:"#FFF",pointBorderWidth:1,pointHoverBorderWidth:1,pointRadius:3,}]};
        var config={type:'line',options:chartOptions,data:chartData};
        var lineChart=new Chart(ctx,config);


    }

    static create_table(for_table){
   

  // LET'S SAY THAT WE HAVE A SIMPLE FLAT ARRAY
 // var data = ["doge", "cate", "birb", "doggo", "moon moon", "awkward seal"];
  var data = for_table;

  // DRAW THE HTML TABLE
  var perrow = 3, // 3 items per row
      html = "<table><tr>";

  // Loop through array and add table cells
  for (var i=0; i<data.length; i++) {
    html += "<td>" + data[i] + "</td>";
    // Break into next row
    var next = i+1;
    if (next%perrow==0 && next!=data.length) {
      html += "</tr><tr>";
    }
  }
  html += "</tr></table>";

  // ATTACH HTML TO CONTAINER
  document.getElementById("table").innerHTML = html;
};
    

   
}

document.addEventListener("DOMContentLoaded", function() {
    const history = new History();
})
