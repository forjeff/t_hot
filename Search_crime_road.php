<?php
    include ("Member_menu.php");
    include ("Member_function.php");
?>
<html>
    <head>
        <title>失竊路段查詢</title>
        <meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
        <style>
            /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
            #map {
                height: 90%;
            }
            /* Optional: Makes the sample page fill the window. */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            #floating-panel {
                position: absolute;
                bottom: 5px;
                left: 5px;
                z-index: 5;
                background-color: #fff;
                padding: 5px;
                border: 1px solid #999;
                text-align: center;
                font-family: 'Roboto','sans-serif';
            }
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC95arVG_ueHOf2FslDsMYwSsoqvv7Oyw&libraries=visualization"></script>
        <script src="jquery-3.2.1.min.js"></script>
    </head>
    <script type="text/javascript">
        $(document).ready(function(){
            GetData("住宅竊盜");
            WriteSearchRecord(<?php echo "\"".$user_id."\""; ?>, $("#keyword").val(), $("#crime_type").val());
        });

        function GetData(crime_type){
            $.ajax({
                type: "POST",
                url: "Member_handler.php",
                dataType: "json",
                data: {fun_name: "SearchCrimeRoad", type: crime_type},
                success: function(response){
                    console.log("Get data successfully. total:" + response.length);
                    ProcessData(response);
                }
            });
        }

        function WriteSearchRecord(user_id, keyword, type){
            $.ajax({
                type: "POST",
                url: "Member_handler.php",
                dataType: "json",
                data: {fun_name: "SaveSearchCrimeRoadRecord", user_id: user_id, keyword: keyword, type: type},
                success: function(response){
                    console.log("Insert search record successfully");
                }
            });
        }

        function ProcessData(response_data){
            /* Process data*/
            var map_data = [];
            for (var i=0; i<response_data.length; i++){
                map_data.push(new google.maps.LatLng(response_data[i].latitude, response_data[i].longitude));
            }

            /* Data points defined as an array of LatLng objects */
            console.log(map_data.length);
            var heatmapData = map_data;
            var default_location = new google.maps.LatLng(24.9750660, 121.2506718);
            var map;
            map = new google.maps.Map(document.getElementById('map'), {
                center: default_location,
                zoom: 12,
                mapTypeId: 'roadmap'
            });

            var styledMapType = new google.maps.StyledMapType(
                [
                    {
                        "featureType": "administrative.land_parcel",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    }
                ],
                {name: 'Styled Map'});

            //map.mapTypes.set('styled_map', styledMapType);
            //map.setMapTypeId('styled_map');

            var heatmap = new google.maps.visualization.HeatmapLayer({
                data: heatmapData,
                dissipating: true,
                maxIntensity: 15
            });
            heatmap.setMap(map);

            // search & pin locations
            var geocoder = new google.maps.Geocoder();
            var keyword = document.getElementById('keyword').value;
            geocoder.geocode({'address': keyword}, function(results, status) {
                if (status === 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

        function SearchRoad(){
            GetData($("#crime_type").val());
            if($("#keyword").val()!=""){
                WriteSearchRecord(<?php echo "\"".$user_id."\""; ?>, $("#keyword").val(), $("#crime_type").val());
            }
        }
    </script>
    <body>
        <div id="floating-panel" style="background-color: rgba(60, 60, 60, 0.7)">
            <select id="crime_type">
                <?php
                    $member = new Member_function();
                    $type_list_data = $member->getSearchTypeList('竊盜');
                    foreach($type_list_data as $row){
                        echo "<option value='".$row['search_type_id']."'>".$row['search_type_name']."</option>";
                    }
                ?>
                <!--<option value="住宅竊盜">住宅竊盜</option>
                <option value="機車竊盜">機車竊盜</option>
                <option value="汽車竊盜">汽車竊盜</option>
                <option value="自行車竊盜">自行車竊盜</option>-->
            </select>
            <input id="keyword" type=text value="中央大學">
            <input onclick="SearchRoad();" type=button value="查詢">
        </div>
        <div id="map"></div>
    </body>
</html>
