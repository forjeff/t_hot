<?php
include('Government_function.php');
include ('Government_menu.php');

if (array_key_exists("post_key", $_POST)){
    $gov = new Government_function();
    $date_begin = $_POST["date_year_begin"]."/".$_POST["date_month_begin"]."/01";
    $date_end_string = $_POST["date_year_end"]."/".$_POST["date_month_end"]."/01";
    $date_end = $d = (new DateTime($date_end_string))->add(new DateInterval('P1M'))->format("Y/m/d");

    $search_type = "";
    if ($_POST["search_type"]=="all"){
        $search_type = 0;
    }
    else if ($_POST["search_type"]=="traffic_accident"){
        $search_type = 1;
    }
    else {
        $search_type = 2;
    }
    $data = $gov->ShowKeywordStatistic($date_begin, $date_end, $search_type);
}
?>
<html>
    <head>
        <title>搜尋關鍵字統計</title>
        <meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
        <script src="d3.min.js" type="text/javascript"></script>
        <script src="d3pie.min.js" type="text/javascript"></script>
    </head>
    <style type="text/css">
        body{
            text-align: center;
        }

        h1{
            color: teal;
        }

        body td{
            vertical-align: top;
        }

        .table_left{
            background-color: darkseagreen;
            border-bottom-style: dashed;
            border-bottom-color: olive;
            border-bottom-width: 1px;
        }

        .table_right{
            background-color: beige;
            border-bottom-style: dashed;
            border-bottom-color: lightseagreen;
            border-bottom-width: 1px;
        }

        form{
            width: 600px;
            margin: 0 auto;
        }

        form table{
            border-collapse: collapse;
            width: 500px;
            margin:0 auto;
        }

        .result_div{
            width: 100%;

        }

        .result_tb{
            width: 600px;
            margin: 0 auto;
        }

        .result_tb .numbers{
            text-align: right;
        }
    </style>

    <body>
        <h1>搜尋關鍵字統計</h1>
        <form action="Show_keyword_statistic.php" method="post">
            <input type="hidden" name="post_key" value="search">
            <table>
                <tr>
                    <td class="table_left">查詢範圍</td>
                    <td class="table_right">
                        起(年,月)
                        <select name="date_year_begin">
                            <option value="2017">2017</option>
                            <option value="2018" selected="selected">2018</option>
                        </select>
                        <select name="date_month_begin">
                            <option value="1" selected="selected">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <br/>
                        迄(年,月)
                        <select name="date_year_end">
                            <option value="2017">2017</option>
                            <option value="2018" selected="selected">2018</option>
                        </select>
                        <select name="date_month_end">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="table_left">查詢類型</td>
                    <td class="table_right">
                        <input type="radio" name="search_type" value="all" checked="checked">全部<br>
                        <input type="radio" name="search_type" value="traffic_accident">事故路段<br>
                        <input type="radio" name="search_type" value="crime">失竊路段<br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;" colspan="2">
                        <input type="submit" value="查詢">
                    </td>
                </tr>
            </table>
        </form>
        <hr>
        <div id="pieChart"></div>
        <?php
        if (array_key_exists("post_key", $_POST)){

            $sum = 0;
            foreach($data as $row){
                $sum += intval($row["statistic"]);
            }
            echo "<div class='result_div'>";
            echo "<table class='result_tb'>";
            echo "<tr><td>搜尋類型</td><td>關鍵字</td><td class='numbers'>統計次數</td><td class='numbers'>比例</td></tr>";

            $percent = 0;
            $percent_sum = 0;
            $pie_chart_json = "[";
            for ($i = 0; $i < count($data); $i ++) {
                $percent = round(intval($data[$i]["statistic"]) / $sum * 100,1);
                $pie_chart_json .= "{'label':'".$data[$i]["search_type"].", ".$data[$i]["key_word"]."', 'value':".$data[$i]["statistic"]."}";

                if ($i == count($data)-1 ){
                    $percent = 100 - $percent_sum;
                }
                else{
                    $percent_sum += $percent;
                    $pie_chart_json .= ",";
                }

                echo "<tr><td>".$data[$i]["search_type"]."</td><td>".$data[$i]["key_word"]."</td><td class='numbers'>".$data[$i]["statistic"]."</td><td class='numbers'>".round($percent, 1)."%</td></tr>";
            }
            $pie_chart_json .= "]";

            echo "</table>";
            echo "</div>";
        }
        ?>
        <script>
            var data = {
                "header": {
                    "title": {
                        "text": "關鍵字分佈圖",
                        "fontSize": 24,
                        "font": "open sans"
                    },
                    "subtitle": {
                        "text": "",
                        "color": "#999999",
                        "fontSize": 12,
                        "font": "open sans"
                    },
                    "titleSubtitlePadding": 9
                },
                "footer": {
                    "color": "#999999",
                    "fontSize": 10,
                    "font": "open sans",
                    "location": "bottom-left"
                },
                "size": {
                    "canvasWidth": 660,
                    "pieOuterRadius": "75%"
                },
                "data": {
                    "sortOrder": "value-desc",
                    "content": <?php echo $pie_chart_json; ?>
                },
                "labels": {
                    "outer": {
                        "pieDistance": 32
                    },
                    "inner": {
                        "hideWhenLessThanPercentage": 3
                    },
                    "mainLabel": {
                        "fontSize": 11
                    },
                    "percentage": {
                        "color": "#ffffff",
                        "decimalPlaces": 1
                    },
                    "value": {
                        "color": "#adadad",
                        "fontSize": 11
                    },
                    "lines": {
                        "enabled": true
                    },
                    "truncation": {
                        "enabled": true
                    }
                },
                "effects": {
                    "pullOutSegmentOnClick": {
                        "effect": "linear",
                        "speed": 400,
                        "size": 8
                    }
                },
                "misc": {
                    "gradient": {
                        "enabled": true,
                        "percentage": 100
                    }
                }
            };


            document.addEventListener("DOMContentLoaded", function(e) {
                /* Your D3.js here */
                var pie = new d3pie("pieChart", data);
            });
        </script>
    </body>
</html>
