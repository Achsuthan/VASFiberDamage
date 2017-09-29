


var mapid=Array();
var lat=Array();
var lng=Array();

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        output = JSON.parse(this.responseText);
        for(var i=0; i<output.length; i++)
        {
            lat.push(output[i]["lat"]);
            lng.push(output[i]["lng"]);
            var start = document.getElementById("row");
            var cdiv = document.createElement('div');
            cdiv.className = "col-sm-4";
            cdiv.style = "border-color:#333;";
            start.appendChild(cdiv);


            var header = document.createElement('h3');
            header.innerHTML = output[i]["dam_id"];
            cdiv.appendChild(header);

            var mapdiv = document.createElement('div');
            mapdiv.id = "map"+i;
            mapid.push("map"+i);
            mapdiv.style = "width:250px;height:250px;background:blue";
            cdiv.appendChild(mapdiv);


            var br = document.createElement('br');
            cdiv.appendChild(br);
            var picdiv = document.createElement('div');
            picdiv.style = "width:300px;height:300px;";


            var pic = document.createElement('img');
            pic.src = output[i]["pic_path"];
            pic.style = "max-width: 250px; max-height:250px;";
            picdiv.appendChild(pic);
            cdiv.appendChild(picdiv);

            initMap();
        }

    }
};
xmlhttp.open("GET", "http://localhost/fib/get_damage_details.php");
xmlhttp.send();



function initMap() {
    for(var j=0; j<mapid.length; j++) {
        var uluru = {lat: parseInt(lat[j]), lng: parseInt(lng[j])};
        var map = new google.maps.Map(document.getElementById('map'+j), {
            zoom: 4,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
}


