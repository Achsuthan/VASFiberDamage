/**
 * Created by achsuthanmahendran on 9/7/17.
 */

var xmlhttp = new XMLHttpRequest();
var data = new FormData();
data.append("status", "NEW");
xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        //output = JSON.parse(this.responseText);
        document.getElementById("mytable").innerHTML = this.responseText;

    }
};
xmlhttp.open("POST", "http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/get_damage_details.php");
xmlhttp.send(data);

function status(id,change)
{
    if(change=="WIP" || change=="Complete" || change=="Delete")
    {
        var comment="";
        var person = prompt("Please enter your comment for " + change, "");
        if (person != null) {
            comment=person;
			
			var data = new FormData();
        data.append("change", change);
        data.append("comment",comment);
        data.append("id", id);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {


                var data2 = new FormData();
                data2.append("status", "NEW");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        //output = JSON.parse(this.responseText);
                        document.getElementById("mytable").innerHTML = this.responseText;

                    }
                };
                xmlhttp.open("POST", "http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/get_damage_details.php");
                xmlhttp.send(data2);

            }
        };
        xmlhttp.open("POST", "http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/change_damage.php");
        xmlhttp.send(data);
        }
        
    }
    else
    {
        alert("Project Deteted")
    }
}

function change(status)
{

    var xmlhttp = new XMLHttpRequest();
    var data = new FormData();
    data.append("status", status);
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //output = JSON.parse(this.responseText);
            document.getElementById("mytable").innerHTML = this.responseText;

        }
    };
    xmlhttp.open("POST", "http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/get_damage_details.php");
    xmlhttp.send(data);
}


