(function($) {
  'use strict';

  $(function() {
    if ($("#order-chart").length) {
      var areaData = {
        labels: ["10","","","20","","","30","","","40","","", "50","","", "60","","","70"],
        datasets: [
          {
            data: [200, 480, 700, 600, 620, 350, 380, 350, 850, "600", "650", "350", "590", "350", "620", "500", "990", "780", "650"],
            borderColor: [
              '#4747A1'
            ],
            borderWidth: 2,
            fill: false,
            label: "Orders"
          },
          {
            data: [400, 450, 410, 500, 480, 600, 450, 550, 460, "560", "450", "700", "450", "640", "550", "650", "400", "850", "800"],
            borderColor: [
              '#F09397'
            ],
            borderWidth: 2,
            fill: false,
            label: "Downloads"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          filler: {
            propagate: false
          }
        },
        scales: {
          xAxes: [{
            display: true,
            ticks: {
              display: true,
              padding: 10,
              fontColor:"#6C7383"
            },
            gridLines: {
              display: false,
              drawBorder: false,
              color: 'transparent',
              zeroLineColor: '#eeeeee'
            }
          }],
          yAxes: [{
            display: true,
            ticks: {
              display: true,
              autoSkip: false,
              maxRotation: 0,
              stepSize: 200,
              min: 200,
              max: 1200,
              padding: 18,
              fontColor:"#6C7383"
            },
            gridLines: {
              display: true,
              color:"#f2f2f2",
              drawBorder: false
            }
          }]
        },
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        elements: {
          line: {
            tension: .35
          },
          point: {
            radius: 0
          }
        }
      }
      var revenueChartCanvas = $("#order-chart").get(0).getContext("2d");
      var revenueChart = new Chart(revenueChartCanvas, {
        type: 'line',
        data: areaData,
        options: areaOptions
      });
    }
    if ($("#order-chart-dark").length) {
      var areaData = {
        labels: ["10","","","20","","","30","","","40","","", "50","","", "60","","","70"],
        datasets: [
          {
            data: [200, 480, 700, 600, 620, 350, 380, 350, 850, "600", "650", "350", "590", "350", "620", "500", "990", "780", "650"],
            borderColor: [
              '#4747A1'
            ],
            borderWidth: 2,
            fill: false,
            label: "Orders"
          },
          {
            data: [400, 450, 410, 500, 480, 600, 450, 550, 460, "560", "450", "700", "450", "640", "550", "650", "400", "850", "800"],
            borderColor: [
              '#F09397'
            ],
            borderWidth: 2,
            fill: false,
            label: "Downloads"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          filler: {
            propagate: false
          }
        },
        scales: {
          xAxes: [{
            display: true,
            ticks: {
              display: true,
              padding: 10,
              fontColor:"#fff"
            },
            gridLines: {
              display: false,
              drawBorder: false,
              color: 'transparent',
              zeroLineColor: '#575757'
            }
          }],
          yAxes: [{
            display: true,
            ticks: {
              display: true,
              autoSkip: false,
              maxRotation: 0,
              stepSize: 200,
              min: 200,
              max: 1200,
              padding: 18,
              fontColor:"#fff"
            },
            gridLines: {
              display: true,
              color:"#575757",
              drawBorder: false
            }
          }]
        },
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        elements: {
          line: {
            tension: .35
          },
          point: {
            radius: 0
          }
        }
      }
      var revenueChartCanvas = $("#order-chart-dark").get(0).getContext("2d");
      var revenueChart = new Chart(revenueChartCanvas, {
        type: 'line',
        data: areaData,
        options: areaOptions
      });
    }
    if ($("#sales-chart").length) {
      var SalesChartCanvas = $("#sales-chart").get(0).getContext("2d");
      var SalesChart = new Chart(SalesChartCanvas, {
        type: 'bar',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May"],
          datasets: [{
              label: 'Offline Sales',
              data: [480, 230, 470, 210, 330],
              backgroundColor: '#98BDFF'
            },
            {
              label: 'Online Sales',
              data: [400, 340, 550, 480, 170],
              backgroundColor: '#4B49AC'
            }
          ]
        },
        options: {
          cornerRadius: 5,
          responsive: true,
          maintainAspectRatio: true,
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 20,
              bottom: 0
            }
          },
          scales: {
            yAxes: [{
              display: true,
              gridLines: {
                display: true,
                drawBorder: false,
                color: "#F2F2F2"
              },
              ticks: {
                display: true,
                min: 0,
                max: 560,
                callback: function(value, index, values) {
                  return  value + '$' ;
                },
                autoSkip: true,
                maxTicksLimit: 10,
                fontColor:"#6C7383"
              }
            }],
            xAxes: [{
              stacked: false,
              ticks: {
                beginAtZero: true,
                fontColor: "#6C7383"
              },
              gridLines: {
                color: "rgba(0, 0, 0, 0)",
                display: false
              },
              barPercentage: 1
            }]
          },
          legend: {
            display: false
          },
          elements: {
            point: {
              radius: 0
            }
          }
        },
      });
      document.getElementById('sales-legend').innerHTML = SalesChart.generateLegend();
    }
    if ($("#sales-chart-dark").length) {
      var SalesChartCanvas = $("#sales-chart-dark").get(0).getContext("2d");
      var SalesChart = new Chart(SalesChartCanvas, {
        type: 'bar',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May"],
          datasets: [{
              label: 'Offline Sales',
              data: [480, 230, 470, 210, 330],
              backgroundColor: '#98BDFF'
            },
            {
              label: 'Online Sales',
              data: [400, 340, 550, 480, 170],
              backgroundColor: '#4B49AC'
            }
          ]
        },
        options: {
          cornerRadius: 5,
          responsive: true,
          maintainAspectRatio: true,
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 20,
              bottom: 0
            }
          },
          scales: {
            yAxes: [{
              display: true,
              gridLines: {
                display: true,
                drawBorder: false,
                color: "#575757"
              },
              ticks: {
                display: true,
                min: 0,
                max: 500,
                callback: function(value, index, values) {
                  return  value + '$' ;
                },
                autoSkip: true,
                maxTicksLimit: 10,
                fontColor:"#F0F0F0"
              }
            }],
            xAxes: [{
              stacked: false,
              ticks: {
                beginAtZero: true,
                fontColor: "#F0F0F0"
              },
              gridLines: {
                color: "#575757",
                display: false
              },
              barPercentage: 1
            }]
          },
          legend: {
            display: false
          },
          elements: {
            point: {
              radius: 0
            }
          }
        },
      });
      document.getElementById('sales-legend').innerHTML = SalesChart.generateLegend();
    }
    if ($("#north-america-chart").length) {
      var areaData = {
        labels: ["Jan", "Feb", "Mar"],
        datasets: [{
            data: [100, 50, 50],
            backgroundColor: [
               "#4B49AC","#FFC100", "#248AFD",
            ],
            borderColor: "rgba(0,0,0,0)"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
          arc: {
              borderWidth: 4
          }
        },      
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        legendCallback: function(chart) { 
          var text = [];
          text.push('<div class="report-chart">');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
            text.push('<p class="mb-0">88333</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
            text.push('<p class="mb-0">66093</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
            text.push('<p class="mb-0">39836</p>');
            text.push('</div>');
          text.push('</div>');
          return text.join("");
        },
      }
      var northAmericaChartPlugins = {
        beforeDraw: function(chart) {
          var width = chart.chart.width,
              height = chart.chart.height,
              ctx = chart.chart.ctx;
      
          ctx.restore();
          var fontSize = 3.125;
          ctx.font = "500 " + fontSize + "em sans-serif";
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#13381B";
      
          var text = "90",
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
      
          ctx.fillText(text, textX, textY);
          ctx.save();
        }
      }
      var northAmericaChartCanvas = $("#north-america-chart").get(0).getContext("2d");
      var northAmericaChart = new Chart(northAmericaChartCanvas, {
        type: 'doughnut',
        data: areaData,
        options: areaOptions,
        plugins: northAmericaChartPlugins
      });
      document.getElementById('north-america-legend').innerHTML = northAmericaChart.generateLegend();
    }
    if ($("#north-america-chart-dark").length) {
      var areaData = {
        labels: ["Jan", "Feb", "Mar"],
        datasets: [{
            data: [100, 50, 50],
            backgroundColor: [
               "#4B49AC","#FFC100", "#248AFD",
            ],
            borderColor: "rgba(0,0,0,0)"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
          arc: {
              borderWidth: 4
          }
        },      
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        legendCallback: function(chart) { 
          var text = [];
          text.push('<div class="report-chart">');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
            text.push('<p class="mb-0">88333</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
            text.push('<p class="mb-0">66093</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
            text.push('<p class="mb-0">39836</p>');
            text.push('</div>');
          text.push('</div>');
          return text.join("");
        },
      }
      var northAmericaChartPlugins = {
        beforeDraw: function(chart) {
          var width = chart.chart.width,
              height = chart.chart.height,
              ctx = chart.chart.ctx;
      
          ctx.restore();
          var fontSize = 3.125;
          ctx.font = "500 " + fontSize + "em sans-serif";
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#fff";
      
          var text = "90",
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
      
          ctx.fillText(text, textX, textY);
          ctx.save();
        }
      }
      var northAmericaChartCanvas = $("#north-america-chart-dark").get(0).getContext("2d");
      var northAmericaChart = new Chart(northAmericaChartCanvas, {
        type: 'doughnut',
        data: areaData,
        options: areaOptions,
        plugins: northAmericaChartPlugins
      });
      document.getElementById('north-america-legend').innerHTML = northAmericaChart.generateLegend();
    }

    if ($("#south-america-chart").length) {
      var areaData = {
        labels: ["Jan", "Feb", "Mar"],
        datasets: [{
            data: [60, 70, 70],
            backgroundColor: [
              "#4B49AC","#FFC100", "#248AFD",
            ],
            borderColor: "rgba(0,0,0,0)"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
          arc: {
              borderWidth: 4
          }
        },      
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        legendCallback: function(chart) { 
          var text = [];
          text.push('<div class="report-chart">');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
            text.push('<p class="mb-0">495343</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
            text.push('<p class="mb-0">630983</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
            text.push('<p class="mb-0">290831</p>');
            text.push('</div>');
          text.push('</div>');
          return text.join("");
        },
      }
      var southAmericaChartPlugins = {
        beforeDraw: function(chart) {
          var width = chart.chart.width,
              height = chart.chart.height,
              ctx = chart.chart.ctx;
      
          ctx.restore();
          var fontSize = 3.125;
          ctx.font = "600 " + fontSize + "em sans-serif";
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#000";
      
          var text = "76",
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
      
          ctx.fillText(text, textX, textY);
          ctx.save();
        }
      }
      var southAmericaChartCanvas = $("#south-america-chart").get(0).getContext("2d");
      var southAmericaChart = new Chart(southAmericaChartCanvas, {
        type: 'doughnut',
        data: areaData,
        options: areaOptions,
        plugins: southAmericaChartPlugins
      });
      document.getElementById('south-america-legend').innerHTML = southAmericaChart.generateLegend();
    }
    if ($("#south-america-chart-dark").length) {
      var areaData = {
        labels: ["Jan", "Feb", "Mar"],
        datasets: [{
            data: [60, 70, 70],
            backgroundColor: [
              "#4B49AC","#FFC100", "#248AFD",
            ],
            borderColor: "rgba(0,0,0,0)"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
          arc: {
              borderWidth: 4
          }
        },      
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        legendCallback: function(chart) { 
          var text = [];
          text.push('<div class="report-chart">');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
            text.push('<p class="mb-0">495343</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
            text.push('<p class="mb-0">630983</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
            text.push('<p class="mb-0">290831</p>');
            text.push('</div>');
          text.push('</div>');
          return text.join("");
        },
      }
      var southAmericaChartPlugins = {
        beforeDraw: function(chart) {
          var width = chart.chart.width,
              height = chart.chart.height,
              ctx = chart.chart.ctx;
      
          ctx.restore();
          var fontSize = 3.125;
          ctx.font = "600 " + fontSize + "em sans-serif";
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#fff";
      
          var text = "76",
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
      
          ctx.fillText(text, textX, textY);
          ctx.save();
        }
      }
      var southAmericaChartCanvas = $("#south-america-chart-dark").get(0).getContext("2d");
      var southAmericaChart = new Chart(southAmericaChartCanvas, {
        type: 'doughnut',
        data: areaData,
        options: areaOptions,
        plugins: southAmericaChartPlugins
      });
      document.getElementById('south-america-legend').innerHTML = southAmericaChart.generateLegend();
    }

  // de aici am adaugat

  $('#maxlength-textarea').maxlength({
    alwaysShow: true,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger"
  });
  
  $('#multiselect').multiselect();
  $('#multiselect2').multiselect();


  
$('#admins').DataTable( {
    "order": [[ 3, "asc" ]],
    responsive: true,
    displayLength: 7,
    lengthMenu: [7, 10, 15, 20, 25, 50],
    'columns': [
      { data: 'User' },
      { data: 'Username' },
      { data: 'Email' }, 
      { data: '' }, 
      { data: 'Active' },
      { data: 'Verified'},
      { data: 'Created at' }, 
      { data: 'Last login' }, 
      { data: 'Action' } 
   ], 
    'columnDefs': [ {
      'targets': [0, 8], // column index (start from 0)
      'orderable': false // set orderable false for selected columns
   },
   {
     'targets': 0,
     'render': function ( data, type, row ) {
      return '<img src="../../images/user_uploads/' + data + '" alt="Avatar" class="rounded-circle" style="width:30px;">';
    }
   },
   {
    'targets': [1, 2],
    'visible': false
   }
  ],

   dom: '<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            
   buttons: [
    {
      extend: 'collection',
      className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
      text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
      buttons: [
        {
          extend: "print",
          text: '<i class="ti-printer me-2" ></i>Print',
          className: 'dropdown-item',
          exportOptions: { columns: [1, 2, 4, 5, 6, 7] }
        },
        {
          extend: "csv",
          text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
          className: 'dropdown-item',
          exportOptions: { columns: [1, 2, 4, 5, 6, 7] }
        },
        {
          extend: "pdf",
          text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
          className: 'dropdown-item',
          exportOptions: { columns: [1, 2, 4, 5, 6, 7] }
        },
        {
          extend: "excel",
          text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
          className: 'dropdown-item',
          exportOptions: { columns: [1, 2, 4, 5, 6, 7] }
        },
        {
          extend: "copy",
          text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
          className: 'dropdown-item',
          exportOptions: { columns: [1, 2, 4, 5, 6, 7] }
        }
      ]
    },
{     action: function ( e, dt, button, config ) {
      window.location = 'newuser.php';
},
      text: '<i class="ti-plus me-0 me-sm-2"></i><span class="d-none d-lg-inline-block">Add new user</span>',
      className: 'btn-new-user btn'
    },
  ],
  
}); 

$('#city').DataTable({
  "order": [[ 1, "desc" ]],
  responsive: true,
  dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      }
    ]
  }
 ]
});

$('#country').DataTable({
  "order": [[ 1, "desc" ]],
  responsive: true,
  dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      }
    ]
  }
 ]
});

$('#region').DataTable({
  "order": [[ 1, "desc" ]],
  responsive: true,
  dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      }
    ]
  }
 ]
});

$('#pages_list').DataTable( {
  "order": [[ 0, "asc" ]],
  responsive: true,
 displayLength: 7,
  lengthMenu: [7, 10, 15, 20, 25, 50],
  'columns': [
    { data: 'Title' },
    { data: 'Description' },
    { data: 'Status' }, 
    { data: 'LastModification' }, 
    { data: 'Action' } 
 ], 
  'columnDefs': [ {
    'targets': 4, // column index (start from 0)
    'orderable': false // set orderable false for selected columns
 }],

 dom: '<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3] }
      }
    ]
  },
{     action: function ( e, dt, button, config ) {
    window.location = 'newpage.php';
},
    text: '<i class="ti-plus me-0 me-sm-2"></i><span class="d-none d-lg-inline-block">Add new page</span>',
    className: 'btn-new-user btn'
  },
]

}); 

$('#logon_attempts').DataTable( {
  "order": [[ 0, "asc" ]],
  responsive: true,
  displayLength: 7,
  lengthMenu: [7, 10, 15, 20, 25, 50],
  'columns': [
    { data: 'Email' },
    { data: 'User info' },
    { data: 'Location' },
    { data: 'Browser' },
    { data: 'OS' },
    { data: 'Device' },
    { data: 'Date' }, 
    { data: 'Error reason' }
 ], 
  'columnDefs': [ {
    'targets': 1, // column index (start from 0)
    'orderable': false // set orderable false for selected columns
 },
 {
  'targets': [2, 3, 4, 5],
  'visible': false
 }
],

dom: '<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          
buttons: [
 {
   extend: 'collection',
   className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
   text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
   buttons: [
     {
       extend: "print",
       text: '<i class="ti-printer me-2" ></i>Print',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7] }
     },
     {
       extend: "csv",
       text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7] }
     },
     {
       extend: "pdf",
       text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7] }
     },
     {
       extend: "excel",
       text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7] }
     },
     {
       extend: "copy",
       text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7] }
     }
   ]
 }
]
}); 

$('#os').DataTable({
  "order": [[ 1, "desc" ]],
  responsive: true,

 dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      }
    ]
  }
 ]
});
  

$('#browser').DataTable({
  "order": [[ 1, "desc" ]],
  responsive: true,

 dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      }
    ]
  }
 ]
});

$('#device').DataTable({
  "order": [[ 1, "desc" ]],
  responsive: true,
 dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      }
    ]
  }
 ]
});

$('#hours').DataTable({
  "order": [[ 1, "desc" ]],
  responsive: true,
  displayLength: 24,
 dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1] }
      }
    ]
  }
 ]
});


$('#userstype').DataTable( {
  "order": [[ 0, "asc" ]],
  responsive: true,
  displayLength: 7,
  lengthMenu: [7, 10, 15, 20, 25, 50],

dom: '<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          
buttons: [
 {
   extend: 'collection',
   className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
   text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
   buttons: [
     {
       extend: "print",
       text: '<i class="ti-printer me-2" ></i>Print',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     },
     {
       extend: "csv",
       text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     },
     {
       extend: "pdf",
       text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     },
     {
       extend: "excel",
       text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     },
     {
       extend: "copy",
       text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     }
   ]
 }
]
});

$('#pgs').DataTable( {
  "order": [[ 0, "asc" ]],
  responsive: true,
  displayLength: 7,
  lengthMenu: [7, 10, 15, 20, 25, 50],
  'columns': [
    { data: 'Title' },
    { data: 'Page views' },
    { data: 'Unique viewers' },
    { data: 'Sessions' },
    { data: 'Avg. time on page' },
    { data: 'Bounce rate' },
    { data: 'Exit rate' }
 ], 
  
dom: '<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          
buttons: [
 {
   extend: 'collection',
   className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
   text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
   buttons: [
     {
       extend: "print",
       text: '<i class="ti-printer me-2" ></i>Print',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     },
     {
       extend: "csv",
       text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     },
     {
       extend: "pdf",
       text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     },
     {
       extend: "excel",
       text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     },
     {
       extend: "copy",
       text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
       className: 'dropdown-item',
       exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
     }
   ]
 }
]
});

$('#accessusers').DataTable( {
  "order": [[ 3, "asc" ]],
  responsive: true,
 displayLength: 7,
  lengthMenu: [7, 10, 15, 20, 25, 50],
  'columns': [
    { data: 'User' },
    { data: 'Username' },
    { data: 'Email' }, 
    { data: '' } 
 ], 
  'columnDefs': [ {
    'targets': [0], // column index (start from 0)
    'orderable': false // set orderable false for selected columns
 },
 {
   'targets': 0,
   'render': function ( data, type, row ) {
    return '<img src="../../images/user_uploads/' + data + '" alt="Avatar" class="rounded-circle" style="width:30px;">';
  }
 },
 {
  'targets': [1, 2],
  'visible': false
 }
],

 dom: '<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      }
]}]
}); 

$('#pagevisits').DataTable( {
  "order": [[ 3, "asc" ]],
  responsive: true,
 displayLength: 7,
  lengthMenu: [7, 10, 15, 20, 25, 50],
  'columns': [
    { data: 'User' },
    { data: 'Username' },
    { data: 'Email' }, 
    { data: '' },
    { data: 'Date' }, 
    { data: 'Time spent' } 
 ], 
  'columnDefs': [ {
    'targets': [0, 5], // column index (start from 0)
    'orderable': false // set orderable false for selected columns
 },
 {
   'targets': 0,
   'render': function ( data, type, row ) {
    return '<img src="../../images/user_uploads/' + data + '" alt="Avatar" class="rounded-circle" style="width:30px;">';
  }
 },
 {
  'targets': [1, 2],
  'visible': false
 }
],

 dom: '<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2, 4, 5] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2, 4, 5] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2, 4, 5] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2, 4, 5] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2, 4, 5] }
      }
]}]
}); 

  
function format (d) {
  // `d` is the original data object for the row
  var result;
  var startd = $('#rangeoutlinks').data('daterangepicker').startDate._d;
  var endd = $('#rangeoutlinks').data('daterangepicker').endDate._d;
  var sd = new Date(startd).toLocaleDateString("en-CA");
  var ed = new Date(endd).toLocaleDateString("en-CA");
  $.ajax({
    async: false,
    type: "GET",
    url: '../assets/admin/outlinkstable.php',
    data: {pg_id: d.ID, sd: sd, ed: ed},
    success: function(data){
    result = data;
    },
    error: function(xhr, status, error){
    console.error(xhr);
    }
   });
   return result;
}

$('#log_duration').DataTable({
  responsive: true,
  'columnDefs': [ {
    'targets': 0, 
    'visible': false 
 }],
 dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      }
    ]
  }
 ]
});

$('#log_pages').DataTable({
  responsive: true,
  'columnDefs': [ {
    'targets': 0, 
    'visible': false 
 }],
 dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      }
    ]
  }
 ]
});

$('#log_number').DataTable({
  responsive: true,
  displayLength: 14,
  'columnDefs': [ {
    'targets': 0, 
    'visible': false 
 }],
 dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      }
    ]
  }
 ]
});

$('#log_days').DataTable({
  responsive: true,
  displayLength: 15,
  'columnDefs': [ {
    'targets': 0, 
    'visible': false 
 }],
 dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [1, 2] }
      }
    ]
  }
 ]
});

$('#ses_log').DataTable({
 dom: '<"row mx-2"<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i>>',
 buttons: [
  {
    extend: 'collection',
    className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
    text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
    buttons: [
      {
        extend: "print",
        text: '<i class="ti-printer me-2" ></i>Print',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
      },
      {
        extend: "csv",
        text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
      },
      {
        extend: "pdf",
        text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
      },
      {
        extend: "excel",
        text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
      },
      {
        extend: "copy",
        text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
        className: 'dropdown-item',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
      }
    ]
  }
 ]
});

var table = $('#outlinks').DataTable( {
  columns: [
     { className: 'dt-control',
        orderable: false,
        data: null,
        defaultContent: '',
        "render": function () {
          return '<i class="ti-plus rgb" aria-hidden="true"></i>';
      },
      width:"15px"},
        { data: "ID",
      visible: false },
      { data: "Page" },
      { data: "Unique users" },
      { data: "Clicks" }
  ],
  order: [[2, 'desc']],
  responsive: true,
   displayLength: 7,
    lengthMenu: [7, 10, 15, 20, 25, 50],

  dom: '<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          
  buttons: [
   {
     extend: 'collection',
     className: "btn-export btn btn-label-secondary dropdown-toggle mx-3",
     text: '<i class="ti-export me-0 me-sm-2 mr-2"></i>Export',
     buttons: [
       {
         extend: "print",
         text: '<i class="ti-printer me-2" ></i>Print',
         className: 'dropdown-item',
         exportOptions: { columns: [2, 3, 4] }
       },
       {
         extend: "csv",
         text: '<span class="iconify me-2" data-icon="bi:filetype-csv"></span>CSV',
         className: 'dropdown-item',
         exportOptions: { columns: [2, 3, 4] }
       },
       {
         extend: "pdf",
         text: '<span class="iconify-inline me-2" data-icon="bi:filetype-pdf"></span>PDF',
         className: 'dropdown-item',
         exportOptions: { columns: [2, 3, 4] }
       },
       {
         extend: "excel",
         text: '<span class="iconify me-2" data-icon="bi:file-earmark-excel"></span>Excel',
         className: 'dropdown-item',
         exportOptions: { columns: [2, 3, 4] }
       },
       {
         extend: "copy",
         text: '<span class="iconify me-2" data-icon="clarity:copy-to-clipboard-line"></span>Copy',
         className: 'dropdown-item',
         exportOptions: { columns: [2, 3, 4] }
       }
 ]}]
  
} );

$('#outlinks tbody').on('click', 'td.dt-control', function () {
  var tr = $(this).closest('tr');
  var tdi = tr.find("i");
  var row = table.row(tr);

  if (row.child.isShown()) {
      // This row is already open - close it
      row.child.hide();
      tr.removeClass('shown');
      tdi.first().removeClass('ti-minus rgb');
      tdi.first().addClass('ti-plus rgb');
  } else {
      // Open this row
      row.child(format(row.data())).show();
      tr.addClass('shown');
      tdi.first().removeClass('ti-plus rgb');
      tdi.first().addClass('ti-minus rgb');
  }
});
  

var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
        "linkedCalendars": false,
        "alwaysShowCalendars": true,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    function cb2(start, end) {
      $('#range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  }

  $('#range').daterangepicker({
    startDate: start,
    endDate: end,
      "linkedCalendars": false,
      "alwaysShowCalendars": true,
      ranges: {
         'Today': [moment(), moment()],
         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
         'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
  }, cb2);

    cb2(start, end);

    function cb3(start, end) {
      $('#rangetimes span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  }

    $('#rangetimes').daterangepicker({
      startDate: start,
      endDate: end,
        "linkedCalendars": false,
        "alwaysShowCalendars": true,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb3);
  
      cb3(start, end);

      function cb4(start, end) {
        $('#rangelocation span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
  
      $('#rangelocation').daterangepicker({
        startDate: start,
        endDate: end,
          "linkedCalendars": false,
          "alwaysShowCalendars": true,
          ranges: {
             'Today': [moment(), moment()],
             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
             'This Month': [moment().startOf('month'), moment().endOf('month')],
             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          }
      }, cb4);
    
        cb4(start, end);

        function cb5(start, end) {
          $('#rangeusertype span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }
    
        $('#rangeusertype').daterangepicker({
          startDate: start,
          endDate: end,
            "linkedCalendars": false,
            "alwaysShowCalendars": true,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb5);
      
          cb5(start, end);

          function cb6(start, end) {
            $('#rangepages span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
      
          $('#rangepages').daterangepicker({
            startDate: start,
            endDate: end,
              "linkedCalendars": false,
              "alwaysShowCalendars": true,
              ranges: {
                 'Today': [moment(), moment()],
                 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                 'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                 'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                 'This Month': [moment().startOf('month'), moment().endOf('month')],
                 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              }
          }, cb6);
        
            cb6(start, end);

            function cb7(start, end) {
              $('#rangeoutlinks span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          }
        
            $('#rangeoutlinks').daterangepicker({
              startDate: start,
              endDate: end,
                "linkedCalendars": false,
                "alwaysShowCalendars": true,
                ranges: {
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb7);
          
              cb7(start, end);
   
              function cb8(start, end) {
                $('#rangeengage span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
          
              $('#rangeengage').daterangepicker({
                startDate: start,
                endDate: end,
                  "linkedCalendars": false,
                  "alwaysShowCalendars": true,
                  ranges: {
                     'Today': [moment(), moment()],
                     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                     'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                     'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                     'This Month': [moment().startOf('month'), moment().endOf('month')],
                     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                  }
              }, cb8);
            
                cb8(start, end);
    
                function cb8(start, end) {
                  $('#rangeengage span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
              }
            
                $('#rangeover').daterangepicker({
                  startDate: start,
                  endDate: end,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    ranges: {
                       'Today': [moment(), moment()],
                       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                       'This Month': [moment().startOf('month'), moment().endOf('month')],
                       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb9);
              
                  cb9(start, end);

                  function cb9(start, end) {
                    $('#rangeover span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }

                $('#rangecontact').daterangepicker({
                  startDate: start,
                  endDate: end,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    ranges: {
                       'Today': [moment(), moment()],
                       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                       'This Month': [moment().startOf('month'), moment().endOf('month')],
                       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb10);
              
                  cb10(start, end);

                  function cb10(start, end) {
                    $('#rangecontact span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }


    $("body").tooltip({ selector: '[data-toggle=tooltip]', html:true });
    
  }); 
})(jQuery);

// calculeaza timpul unui user pe o pagina
if(location.pathname == "/disertation-app/pages/user/page.php"){
 var start1 = new Date().getTime();
 
 $.urlParam = function(name){
  var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
  return results[1] || 0;
}
 var nav = performance.getEntriesByType("navigation")[0].type;

 $(window).on("beforeunload", function() { 
  var end1 = new Date().getTime();
   $.ajax({ 
    type : "POST",
    url : "../assets/user/session_log.php",
    data : {page_id : $.urlParam('id'), uri: location.href, navigation: nav, start_time : start1, time_spent : (end1 - start1)/1000.0},
  })  
}); 
}
else
// timpul petrecut pe un formular
if(location.pathname == "/disertation-app/pages/user/contact.php"){
  submited = 0;
  var start2 = new Date().getTime();

  let hasRun = false; var first_interact = 0;
   $('.form-container').bind('input click focus', () => {
  if (hasRun) return;
  hasRun = true;
  first_interact = new Date().getTime();
});

  $("#submitcontact").click(function(){
    var end2 = new Date().getTime();
    $.ajax({ 
      type : "POST",
      url : "../assets/user/contactform.php",
      data : {start_time: start2, time_spent: end2, f_interact: first_interact, sub: 'Yes'},
      success: function(result){
         //  setTimeout(function(){location.reload(); }, 200); 
           submited = 1;
           const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
          
          Toast.fire({
            icon: 'success',
            title: 'Form sent successfully'
          })
     }
    })
  });
  $(window).on("beforeunload", function() {
      if(submited == 0){     
      var end2 = new Date().getTime();
      $.ajax({ 
        type : "POST",
        url : "../assets/user/contactform.php",
        data : {start_time: start2, time_spent: end2, f_interact: first_interact, sub: 'No'}
      })
   }  
    }); 
}


$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
  role = $('#rolelog :selected').text();
  $.ajax({url:'../admin/sessionlogs.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA"), "role": role},
    success: function(result){
    $('#logpage').html(jQuery(result).find('#logpage').html());
    } 
  });
});

$('#rolelog').change(function() {
  $.ajax({url:'../admin/sessionlogs.php', 
  type: 'post',
   data: { "sdate": new Date($('#reportrange').data('daterangepicker').startDate).toLocaleDateString("en-CA"), "edate": new Date($('#reportrange').data('daterangepicker').startDate).toLocaleDateString("en-CA"), "role" : $(this).val()},
    success: function(result){
      $('#logpage').html(jQuery(result).find('#logpage').html());  
    } 
  });
});

$('#range').on('apply.daterangepicker', function(ev, picker) {
  role = $('#rolesoftware :selected').text();
  $.ajax({url:'../admin/software.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA"), "role": role},
    success: function(result){
    $('#software').html(jQuery(result).find('#software').html());   
    } 
  });
});

$('#rolesoftware').change(function() {
  $.ajax({url:'../admin/software.php', 
  type: 'post',
   data: { "sdate": new Date($('#range').data('daterangepicker').startDate).toLocaleDateString("en-CA"), "edate": new Date($('#range').data('daterangepicker').startDate).toLocaleDateString("en-CA"), "role" : $(this).val()},
    success: function(result){
      $('#software').html(jQuery(result).find('#software').html());   
    } 
  });
});

$('#rangetimes').on('apply.daterangepicker', function(ev, picker) {
  role = $('#roletimes :selected').text();
  $.ajax({url:'../admin/times.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA"), "role": role},
    success: function(result){
    $('#times').html(jQuery(result).find('#times').html());   
    } 
  });
});

$('#roletimes').change(function() {
  $.ajax({url:'../admin/times.php', 
  type: 'post',
   data: { "sdate": new Date($('#rangetimes').data('daterangepicker').startDate).toLocaleDateString("en-CA"), "edate": new Date($('#rangetimes').data('daterangepicker').startDate).toLocaleDateString("en-CA"), "role" : $(this).val()},
    success: function(result){
      $('#times').html(jQuery(result).find('#times').html());   
    } 
  });
});

$('#rangelocation').on('apply.daterangepicker', function(ev, picker) {
  role = $('#roleselect :selected').text();
  $.ajax({url:'../admin/location.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA"), "role": role},
    success: function(result){
    $('#location').html(jQuery(result).find('#location').html());   
    } 
  });
});

$('#roleselect').change(function() {
  $.ajax({url:'../admin/location.php', 
  type: 'post',
   data: { "sdate": new Date($('#rangelocation').data('daterangepicker').startDate).toLocaleDateString("en-CA"), "edate": new Date($('#rangelocation').data('daterangepicker').startDate).toLocaleDateString("en-CA"), "role" : $(this).val()},
    success: function(result){
    $('#location').html(jQuery(result).find('#location').html());   
    } 
  });
});

$('#rangeusertype').on('apply.daterangepicker', function(ev, picker) {
  //do something, like clearing an input
  $.ajax({url:'../admin/usertype.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA")},
    success: function(result){
    //  $("#logpage").html(result);
    $('#usertype').html(jQuery(result).find('#usertype').html());   
    } 
  });
});

$('#rangepages').on('apply.daterangepicker', function(ev, picker) {
  //do something, like clearing an input
  $.ajax({url:'../admin/pagesreport.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA")},
    success: function(result){
    //  $("#logpage").html(result);
    $('#pages').html(jQuery(result).find('#pages').html());   
    } 
  });
});

$('#rangeoutlinks').on('apply.daterangepicker', function(ev, picker) {
  //do something, like clearing an input
  $.ajax({url:'../admin/outlinks.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA")},
    success: function(result){
    //  $("#logpage").html(result);
    $('#links').html(jQuery(result).find('#links').html());   
    } 
  });
});

$('#rangeengage').on('apply.daterangepicker', function(ev, picker) {
  //do something, like clearing an input
  $.ajax({url:'../admin/engagement.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA")},
    success: function(result){
    //  $("#logpage").html(result);
    $('#engage').html(jQuery(result).find('#engage').html());   
    } 
  });
});

$('#rangeover').on('apply.daterangepicker', function(ev, picker) {
  $.ajax({url:'../admin/overview.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA")},
    success: function(result){
    $('#overview').html(jQuery(result).find('#overview').html());   
    } 
  });
});

$('#rangecontact').on('apply.daterangepicker', function(ev, picker) {
  $.ajax({url:'../admin/contact_form.php', 
  type: 'post',
  data: { "sdate": new Date(picker.startDate).toLocaleDateString("en-CA"), "edate": new Date(picker.endDate).toLocaleDateString("en-CA")},
    success: function(result){
    $('#contact_f').html(jQuery(result).find('#contact_f').html());   
    } 
  });
});

function ChangePageStatus(status,id){
  $.post("../../pages/assets/admin/PageStatus.php", { pg_status: status, id: id }, function(){
    window.location.reload();
  });
};

function UserStatus(status,id){
  $.post("../../pages/assets/admin/UserStatus.php", {status: status, id: id }, function(){
     window.location.reload();
  });
};

function DeleteUser(id){
  $.post("../../pages/assets/admin/DeleteUser.php", {id: id })
};

function DeletePage(id){
  $.post("../../pages/assets/admin/DeletePage.php", {id: id })
};

$(".datatables-users tbody").on("click", ".delete-record", function() {
  $('#admins').DataTable().row($(this).parents("tr")).remove().draw();
});

$(".datatables-pages tbody").on("click", ".delete-record", function() {
  $('#pages_list').DataTable().row($(this).parents("tr")).remove().draw();
});

$('#newuser').on('closed.bs.alert', function () {
  $.get("../assets/admin/UserAddedAlert.php");
})

function device_toggle_pie(){
  $('#device_tbl').hide();
  $('#device_bar').hide();
  $('#device_pie').show();
};

function device_toggle_tbl(){
  $('#device_tbl').show();
  $('#device_bar').hide();
  $('#device_pie').hide();
};

function device_toggle_bar(){
  $('#device_tbl').hide();
  $('#device_bar').show();
  $('#device_pie').hide();
};

function os_toggle_pie(){
  $('#os_tbl').hide();
  $('#os_bar').hide();
  $('#os_pie').show();
};

function os_toggle_tbl(){
  $('#os_tbl').show();
  $('#os_bar').hide();
  $('#os_pie').hide();
};

function os_toggle_bar(){
  $('#os_tbl').hide();
  $('#os_bar').show();
  $('#os_pie').hide();
};

function browser_toggle_pie(){
  $('#browser_tbl').hide();
  $('#browser_bar').hide();
  $('#browser_pie').show();
};

function browser_toggle_tbl(){
  $('#browser_tbl').show();
  $('#browser_bar').hide();
  $('#browser_pie').hide();
};

function browser_toggle_bar(){
  $('#browser_tbl').hide();
  $('#browser_bar').show();
  $('#browser_pie').hide();
};

function toggle_add_access(){
  $('#removeaccess').hide();
  $('#addaccess').show();
};

function toggle_remove_access(){
  $('#removeaccess').show();
  $('#addaccess').hide();
};

function logdays_toggle_pie(){
  $('#logdays_tbl').hide();
  $('#logdays_bar').hide();
  $('#logdays_pie').show();
};

function logdays_toggle_tbl(){
  $('#logdays_tbl').show();
  $('#logdays_bar').hide();
  $('#logdays_pie').hide();
};

function logdays_toggle_bar(){
  $('#logdays_tbl').hide();
  $('#logdays_bar').show();
  $('#logdays_pie').hide();
};

function userpg_outlink(link){
  const params = new URLSearchParams(window.location.search);
  const pg_id = params.get("id");
  $.ajax({
    url:'../assets/user/outlink.php', 
    type: 'post',
    data: { pgid: pg_id, url: link}
   })
}

showSwal = function(type, uid) {
  'use strict';
  if (type === 'warning-message-and-cancel') {
    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, disable it!'
    }).then((result) => {
      if (result.isConfirmed) {
        UserStatus('Yes', uid);
        $.post("../../pages/assets/auth/logout.php");
      }
    })

  }
}