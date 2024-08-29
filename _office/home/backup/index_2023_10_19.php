<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :28/02/2565
Author : worapot pilabut (aj.ake)
E-mail : worapot.playdigital@gmail.com
Website : https://conenct.playdigital.co.th
Copyright (C) 2023, Play digital Co.,Ltd. all rights reserved.
 *****************************************************************/


include_once("../../include/config.inc.php");
include_once("../../include/class.inc.php");
include_once("../../include/class.TemplatePower.inc.php");
include_once("../../include/function.inc.php");
include_once("../authentication/check_login.php");



$tpl = new TemplatePower("../template/_tp_inner.html");
$tpl->assignInclude("body", "_tp_index.html");
$tpl->prepare();
$tpl->assign("_ROOT.page_title", "หน้าแรก");
$tpl->assign("_ROOT.logo_brand_alt", $Brand);


// $TodayThaiShow = ThaiToday($strDateTime, $tnow);







$tpl->assign("_ROOT.ScriptTheme", "<script src=\"../html/dist/libs/apexcharts/dist/apexcharts.min.js?1692870487\" defer></script>
    <script>
      // @formatter:off
      document.addEventListener(\"DOMContentLoaded\", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg'), {
          chart: {
            type: \"area\",
            fontFamily: 'inherit',
            height: 40.0,
            sparkline: {
              enabled: true
            },
            animations: {
              enabled: false
            },
          },
          dataLabels: {
            enabled: false,
          },
          fill: {
            opacity: .16,
            type: 'solid'
          },
          stroke: {
            width: 2,
            lineCap: \"round\",
            curve: \"smooth\",
          },
          series: [{
            name: \"Profits\",
            data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67]
          }],
          tooltip: {
            theme: 'dark'
          },
          grid: {
            strokeDashArray: 4,
          },
          xaxis: {
            labels: {
              padding: 0,
            },
            tooltip: {
              enabled: false
            },
            axisBorder: {
              show: false,
            },
            type: 'datetime',
          },
          yaxis: {
            labels: {
              padding: 4
            },
          },
          labels: [
            '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
          ],
          colors: [tabler.getColor(\"primary\")],
          legend: {
            show: false,
          },
        })).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener(\"DOMContentLoaded\", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-new-clients'), {
          chart: {
            type: \"line\",
            fontFamily: 'inherit',
            height: 40.0,
            sparkline: {
              enabled: true
            },
            animations: {
              enabled: false
            },
          },
          fill: {
            opacity: 1,
          },
          stroke: {
            width: [2, 1],
            dashArray: [0, 3],
            lineCap: \"round\",
            curve: \"smooth\",
          },
          series: [{
            name: \"May\",
            data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67]
          },{
            name: \"April\",
            data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37]
          }],
          tooltip: {
            theme: 'dark'
          },
          grid: {
            strokeDashArray: 4,
          },
          xaxis: {
            labels: {
              padding: 0,
            },
            tooltip: {
              enabled: false
            },
            type: 'datetime',
          },
          yaxis: {
            labels: {
              padding: 4
            },
          },
          labels: [
            '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
          ],
          colors: [tabler.getColor(\"primary\"), tabler.getColor(\"gray-600\")],
          legend: {
            show: false,
          },
        })).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener(\"DOMContentLoaded\", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-active-users'), {
          chart: {
            type: \"bar\",
            fontFamily: 'inherit',
            height: 40.0,
            sparkline: {
              enabled: true
            },
            animations: {
              enabled: false
            },
          },
          plotOptions: {
            bar: {
              columnWidth: '50%',
            }
          },
          dataLabels: {
            enabled: false,
          },
          fill: {
            opacity: 1,
          },
          series: [{
            name: \"Profits\",
            data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67]
          }],
          tooltip: {
            theme: 'dark'
          },
          grid: {
            strokeDashArray: 4,
          },
          xaxis: {
            labels: {
              padding: 0,
            },
            tooltip: {
              enabled: false
            },
            axisBorder: {
              show: false,
            },
            type: 'datetime',
          },
          yaxis: {
            labels: {
              padding: 4
            },
          },
          labels: [
            '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
          ],
          colors: [tabler.getColor(\"primary\")],
          legend: {
            show: false,
          },
        })).render();
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener(\"DOMContentLoaded\", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-mentions'), {
          chart: {
            type: \"bar\",
            fontFamily: 'inherit',
            height: 240,
            parentHeightOffset: 0,
            toolbar: {
              show: false,
            },
            animations: {
              enabled: false
            },
            stacked: true,
          },
          plotOptions: {
            bar: {
              columnWidth: '50%',
            }
          },
          dataLabels: {
            enabled: false,
          },
          fill: {
            opacity: 1,
          },
          series: [{
            name: \"Web\",
            data: [1, 0, 0, 0, 0, 1, 1, 0, 0, 0, 2, 12, 5, 8, 22, 6, 8, 6, 4, 1, 8, 24, 29, 51, 40, 47, 23, 26, 50, 26, 41, 22, 46, 47, 81, 46, 6]
          },{
            name: \"Social\",
            data: [2, 5, 4, 3, 3, 1, 4, 7, 5, 1, 2, 5, 3, 2, 6, 7, 7, 1, 5, 5, 2, 12, 4, 6, 18, 3, 5, 2, 13, 15, 20, 47, 18, 15, 11, 10, 0]
          },{
            name: \"Other\",
            data: [2, 9, 1, 7, 8, 3, 6, 5, 5, 4, 6, 4, 1, 9, 3, 6, 7, 5, 2, 8, 4, 9, 1, 2, 6, 7, 5, 1, 8, 3, 2, 3, 4, 9, 7, 1, 6]
          }],
          tooltip: {
            theme: 'dark'
          },
          grid: {
            padding: {
              top: -20,
              right: 0,
              left: -4,
              bottom: -4
            },
            strokeDashArray: 4,
            xaxis: {
              lines: {
                show: true
              }
            },
          },
          xaxis: {
            labels: {
              padding: 0,
            },
            tooltip: {
              enabled: false
            },
            axisBorder: {
              show: false,
            },
            type: 'datetime',
          },
          yaxis: {
            labels: {
              padding: 4
            },
          },
          labels: [
            '2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19', '2020-07-20', '2020-07-21', '2020-07-22', '2020-07-23', '2020-07-24', '2020-07-25', '2020-07-26'
          ],
          colors: [tabler.getColor(\"primary\"), tabler.getColor(\"primary\", 0.8), tabler.getColor(\"green\", 0.8)],
          legend: {
            show: false,
          },
        })).render();
      });
      // @formatter:on
    </script>");






$tpl->assign("_ROOT.Powerby", $Powerby);
$tpl->assign("_ROOT.Copyright", $Copyright);
$tpl->printToScreen();

