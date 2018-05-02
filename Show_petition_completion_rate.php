<?php
include('Government_function.php');
include ('Government_menu.php');

if (array_key_exists("post_key", $_POST)){
    $gov = new Government_function();
    $date_begin = $_POST["date_year_begin"]."/".$_POST["date_month_begin"]."/01";
    $date_end_string = $_POST["date_year_end"]."/".$_POST["date_month_end"]."/01";
    $date_end = $d = (new DateTime($date_end_string))->add(new DateInterval('P1M'))->format("Y/m/d");

    $data = $gov->ShowPetitionCompletionRate($date_begin, $date_end);
    $by_petition_type = $data[0];
    $by_petition_status = $data[1];
}
?>
<html>
    <head>
        <title>陳情完成率統計</title>
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
        <h1>陳情完成率統計</h1>
        <form action="Show_petition_completion_rate.php" method="post">
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

            $total_sum = 0;
            foreach($by_petition_type as $row){
                $total_sum += intval($row["petition_sum"]);
            }

            $percent = 0;
            $percent_sum = 0;
            $pie_chart_json = "[";
            $processed_data = array();
            for ($i = 0; $i < count($by_petition_status); $i ++) {
                $sum_by_type = 1;
                //找到特定petition_type的陳情總和
                foreach($by_petition_type as $row){
                    if($row["type"] == $by_petition_status[$i]["type"]){
                        $sum_by_type = intval($row["petition_sum"]);
                        break;
                    }
                }
                
                $percent = round(intval($by_petition_status[$i]["petition_num"]) / $sum_by_type * 100,1);
                $pie_chart_json .= "{'label':'".$by_petition_status[$i]["type"].", ".$by_petition_status[$i]["status"]."', 'value':".$by_petition_status[$i]["petition_num"]."}";

                if ($i != count($by_petition_status)-1 ){
                    $pie_chart_json .= ",";
                }

                $temp = array($by_petition_status[$i]["type"], $by_petition_status[$i]["status"], intval($by_petition_status[$i]["petition_num"]), round($percent, 1), intval($by_petition_status[$i]["process_spend"]));
                array_push($processed_data, $temp);

                //echo "<tr><td>".$by_petition_status[$i]["type"]."</td><td>".$by_petition_status[$i]["status"]."</td><td class='numbers'>".$by_petition_status[$i]["petition_num"]."</td><td class='numbers'>".round($percent, 1)."%</td></tr>";
            }
            $pie_chart_json .= "]";

            echo "<div class='result_div'>";
            echo "<table class='result_tb'>";
            echo "<tr><td>陳情類別</td><td class='numbers'>已處理</td><td class='numbers'>未處理</td><td class='numbers'>完成率</td></tr>";
            $table_data = array();
            for ($i=0; $i<count($by_petition_type); $i++){
                $complete = 0;
                $complete_rate = 0;
                $not_complete = 0;

                foreach($processed_data as $row){
                    if ($row[0]==$by_petition_type[$i]["type"] && $row[1]=='已處理'){
                        $complete = intval($row[2]);
                        $complete_rate = $row[3];
                    }
                    if ($row[0]==$by_petition_type[$i]["type"] && $row[1]=='未處理'){
                        $not_complete = intval($row[2]);
                    }
                }

                echo "<tr><td>".$by_petition_type[$i]["type"]."</td><td class='numbers'>".$complete."</td><td class='numbers'>".$not_complete."</td><td class='numbers'>".$complete_rate."%</td></tr>";
            }

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
