function initMap() {

    var area_coord = document.getElementById('area_coord').innerHTML;
    area_coord = area_coord.split(',');

    var map = new google.maps.Map(document.getElementById('map'), {
      center: new google.maps.LatLng(parseFloat(area_coord[0]), parseFloat(area_coord[1])),
      zoom: 11
    });
        
        var infoWindow = [];
        var infowincontent = [];
        var marker = [];

        var act = document.getElementById('activities').children;
        
        for(var i=0; i<act.length; i++){
            var name = act[i].children[0].children[1].children[0].children[0].innerHTML;
            var city = act[i].children[0].children[1].children[5].innerHTML;
            var address = act[i].children[0].children[1].children[6].innerHTML;
            var postcode = act[i].children[0].children[1].children[7].innerHTML;
            var coord = act[i].children[0].children[1].children[9].innerHTML;
            coord = coord.split(',');
            var point = new google.maps.LatLng(
                parseFloat(parseFloat(coord[0])),
                parseFloat(parseFloat(coord[1])));

          infowincontent[i] = document.createElement('div');
          var strong = document.createElement('strong');
          strong.textContent = name
          infowincontent[i].appendChild(strong);
          infowincontent[i].appendChild(document.createElement('br'));
          var text = document.createElement('text');
          text.textContent = city + ', ' + address + ', ' + postcode;
          infowincontent[i].appendChild(text);

          marker[i] = new google.maps.Marker({
            map: map,
            position: point,
          });
          marker[i].index = i; //[crucial] additional property to find correct marker from the event listener 

          infoWindow[i] = new google.maps.InfoWindow;

          marker[i].addListener('click', function() {  
            infoWindow[this.index].setContent(infowincontent[this.index]);
            infoWindow[this.index].open(map, marker[this.index]);
          });
        }
}