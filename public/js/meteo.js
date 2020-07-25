let zoneMeteo = document.getElementById("zone_meteo");
let urlApi = "https://api.openweathermap.org/data/2.5/weather?q=Paris&appid=7ac4cbb994df942c15950dd564d47bfc";

let ajax = new XMLHttpRequest();

ajax.open("GET", urlApi, true);
ajax.addEventListener("load", function(){
    let data=JSON.parse(ajax.responseText);
    console.log(data);
    let temp = (data.main.temp-273.15).toFixed(2);
    zoneMeteo.innerHTML = "Météo : " + data.name + " "  + temp + "°";
});
ajax.send();




