window.onload = ()=>{
    var btnCountry = document.getElementById("lookup");
    var btnCities = document.getElementById("lookupCities");
    console.log(btnCountry, btnCities);

    var request;
    btnCountry.addEventListener("click", function(ele) {
        ele.preventDefault();

        const request = new XMLHttpRequest();
        var search = document.getElementById("country").value;
        console.log(search);

        var url = "http://localhost/info2180-lab5/world.php?country="+search;

        request.onreadystatechange = function ()
        {
            if (this.readyState === XMLHttpRequest.DONE) {
            if (request.status ===200) {
            var respnse = request.responseText;
            var holder = document.querySelector("#result").innerHTML = respnse;
            console.log(document.getElementById("result"));
            }
            }
        }
        request.open('Get', url);
        request.send();
    });

    // Lookup button for cities
    btnCities.addEventListener("click", function(ele) {
        ele.preventDefault();

        var request = new XMLHttpRequest();
        var search = document.getElementById("country").value;
        console.log(search);

        var url = "http://localhost/info2180-lab5/world.php?country=" + search + "&lookup=cities";

        request.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE) {
                if (this.status === 200) {
                    var response = request.responseText;
                    document.querySelector("#result").innerHTML = response;
                    console.log(document.getElementById("result"));
                } else {
                    console.error("Request failed with status:", this.status);
                }
            }
        }

        request.open('GET', url);
        request.send();
    });
}