     //Näytetään paljonko varaus maksaa kun valitaan loppuaikaa

function LaskeHinta(hinta){
    var tunnit = $("select#loppu").attr("selectedIndex") + 1;
         
    $("span").text(tunnit*hinta);
}
     