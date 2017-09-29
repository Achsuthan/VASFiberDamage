/**
 * Created by achsuthanmahendran on 9/7/17.
 */



function getpdf()
{
    var from=document.getElementById("from").value;
    var to=document.getElementById("to").value;
    var completed="";
    var wip="";
    if(document.getElementById("new").checked)
    {
        var neww = document.getElementById("new").value;
    }
    else
    {
        neww="";
    }
    if(document.getElementById("wip").checked)
    {
        wip = document.getElementById("wip").value;
    }
    else
    {
        wip="";
    }
    if(document.getElementById("completed").checked)
    {
        completed = document.getElementById("completed").value;
    }
    else
    {
        completed="";
    }

    if(from=="")
    {
        from="empty";
    }
    if(to=="")
    {
        to="empty";
    }
    if(neww=="")
    {
        neww="empty";
    }
    if(wip=="")
    {
        wip="empty";
    }
    if(completed=="")
    {
        completed="empty";
    }

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd;
    }
    if(mm<10){
        mm='0'+mm;
    }
    var today = yyyy+'-'+mm+'-'+dd;

    if(from !="empty" && to=="empty")
    {
        to=today;
    }
    if(to!="empty" && from=="empty")
    {
        from="2017-09-07";
    }

    //alert(from +""+ to+""+wip+""+neww+""+completed );

    var xmlhttp = new XMLHttpRequest();
    var data = new FormData();
    data.append("from", from);
    data.append("to", to);
    data.append("wip", wip);
    data.append("new", neww);
    data.append("completed", completed);
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //var output = JSON.parse(this.responseText);
           // alert(this.responseText);
            window.open(this.responseText,"_blank");

        }
    };
    xmlhttp.open("POST", "http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/get_damage_details_pdf.php");
    xmlhttp.send(data);
}
