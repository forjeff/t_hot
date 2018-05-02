<?php
    require_once("Member_menu.php");
?>
<html lang="en">
    <head>
         <meta charset="utf-8">
        <link href="bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="font-awesome.min.css">
        <style type="text/css">
            /*    --------------------------------------------------
                :: General
                -------------------------------------------------- */
            body {
                font-family: 'Open Sans', sans-serif;
                color: #353535;
            }
            .content h1 {
                font-size: 30px;
                position: absolute;
                top : 10px;
                left: 30%;
                color :#696969;
            }
            .content .content-footer p {
                color: #6d6d6d;
                font-size: 12px;
                text-align: center;
            }
            .content .content-footer p a {
                color: inherit;
                font-weight: bold;
            }
            /*	--------------------------------------------------
                :: Table Filter
                -------------------------------------------------- */
            .panel {
                border: 1px solid #ddd;
                background-color: #fcfcfc;
            }
            .panel .btn-group {
                margin: 15px 0 30px;
            }
            .panel .btn-group .btn {
                display:inline;
                transition: background-color .3s ease;
            }
            .table-filter {
                background-color: #fff;
                border-bottom: 1px solid #eee;
            }
            .table-filter tbody tr:hover {
                cursor: pointer;
                background-color: #eee;
            }
            .table-filter tbody tr td {
                padding: 10px;
                vertical-align: middle;
                border-top-color: #eee;
            }
            .table-filter tbody tr.selected td {
                background-color: #eee;
            }
            .table-filter tr td:first-child {
                width: 38px;
            }
            .table-filter tr td:nth-child(2) {
                width: 35px;
            }
            .table-filter .media-photo {
                width: 35px;
            }
            .table-filter .media-body {
                display: block;
                /* Had to use this style to force the div to expand (wasn't necessary with my bootstrap version 3.3.6) */
            }
            .table-filter .media-meta {
                font-size: 20px;
                color: #999;
            }
            .table-filter .media .title {
                color :#1E90FF;
                font-size: 16px;
                font-weight: bold;
                line-height: normal;
                margin: 0;
            }
            .table-filter .media .title span {
                text-align: center;
            	font-size: 16px;
                margin-right: 20px;
            }
            .table-filter .media .title span.交通{
                color: #5cb85c;
                text-align: center;
            	font-size: 16px;
            }
            .table-filter .media .title span.治安{
                color: #f0ad4e;
                text-align: center;
	            font-size: 16px;
            }
            .table-filter .media .title span.工務{
                color: #d9534f;
                text-align: center;
	            font-size: 16px;
            }
            .table-filter .media .summary {
                font-size: 18px;
            }
            .checked {
                color: orange;
             }
             .colo{
                color :#2BBCDE;
             }
            .f{
                position:relative;
                top: 30px;
                left:5%; 
            }
        </style>
    </head>
    <body>
        <script src="jquery-3.2.1.min.js"></script>
        <!--jquery-3.2.1.min-->
        <script type="text/Javascript">
            $(document).ready(function () {
                $('.btn-filter').on('click', function () {
                    var $target = $(this).data('target');
                  if ($target != '全部') {
                    $('.table tr').css('display', 'none');
                     $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
                   } else {
                     $('.table tr').css('display', 'none').fadeIn('slow');
                   }
               });
               $("tr").click(function(){
                   var id=$(this).attr('id');
                   window.location.href="watch_petition.php?id="+id;
                });
                $( ".f").change(function() {
                    var table, rows, switching, i, x, y, shouldSwitch;
                    var tmp=document.getElementById("number").value;
                    var s=document.getElementById("sort").value;
                    table = document.getElementById("tabler");
                    //alert(document.getElementsByClassName("r").length);
                    switching = true;
                    while (switching) {
                        switching = false;
                        rows = table.getElementsByTagName("TR");
                        //alert(rows[0].getElementsByClassName("r").length);
                        // bug bytagname完不能byname 
                        for (i = 0; i < (rows.length - 1); i++) {
                       // alert(rows.length);
                            shouldSwitch = false;
                            x = rows[i].getElementsByClassName("R")[tmp];
                            //alert(x);
                            y = rows[i + 1].getElementsByClassName("R")[tmp];
                            if(s=='0'){
                                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {//大到小
                                    shouldSwitch= true;
                                    break;
                                }
                            }
                            if(s=='1'){
                                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()){//小到大
                                    shouldSwitch= true;
                                    break;
                                }
                             }   
                        }
                        if (shouldSwitch) {
                            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                            switching = true;
                        }
                    }
                });
             });            
        </script>
        <div class="container">
            <div class="row">
                <section class="content">
                    <div class="col-md-8 col-md-offset-2">
                        
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <select class="f" id="number">
                                    <option selected value='0'>陳情日期</option>
                                    <option value='1'>處理狀態</option>
                                    <option value='2'>陳情類型</option>
                                    <option value='3'>民眾評價</option>
                                    
                                 </select>                                
                                 <select class="f" id="sort">
                                    <option selected value='0'>大</option>
                                    <option value='1'>小</option>
                                 </select>
                                <div class="pull-right">
                                    <h1>陳情文章總覽</h1>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-filter" data-target="交通">交通</button>
                                        <button type="button" class="btn btn-warning btn-filter" data-target="治安">治安</button>
                                        <button type="button" class="btn btn-danger btn-filter" data-target="工務">工務</button>
                                        <button type="button" class="btn btn-default btn-filter" data-target="全部">全部</button>
                                    </div>
                                </div>
                                <div class="table-container">
                                    <table id="tabler" class="table table-filter">
                                        <tbody>
                                            <?php
                                                 require_once 'Member_function.php';
                                                 $member = new Member_function();
                                                 $result = $member->ShowAllPetition();
                                                 foreach ($result as $row) { 
                                                    $tmp=mb_substr($row['content'],0,15,"UTF-8");
                                                    //$tmp=mb_convert_encoding($tmp,UTF-8"); //編碼轉換為utf-8
                                                    $str="";
                                                    for($i=0;$i<round($row['rank']);$i++){
                                                        $str=$str."<p class='fa fa-star checked'></p>";
                                                    }
                                                    for($j=0;$j<5-round($row['rank']);$j++){
                                                        $str=$str."<p class='fa colo fa-star '></p>";
                                                    }
                                                    if($row['gender']=="男"){
                                                        $p="boy.png";
                                                    }
                                                    elseif($row['gender']=="女"){
                                                        $p="girl.png";
                                                    }
                                                    else
                                                        $p="avatar_2x.png"; 
                                                    echo "<tr id='".$row['petition_ID']."' data-status='".$row['type'] ."'><td><div class='media'><a href='#' class='pull-left'> <img src=".$p." class='media-photo'></a><div class='media-body'><span class='media-meta pull-right'><p class='r'>".$row['publish_date']."</p></span><h4 class='title r'>".$row['status'] ."<span class='r pull-right ".$row['type'] ."'><p>".$row['type']."陳情</p> <p class='r' style='display:none'>round(".$row['rank'].")</p> </span>&emsp;&emsp;&emsp;$str</h4><p class='summary'>".$tmp ." ...</p> </div></div></td> </tr>";
                                                 }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </body>
</html>