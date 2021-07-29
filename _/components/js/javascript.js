
$(document).ready(function(e) {
    $('img[usemap]').rwdImageMaps();
    
    var person = prompt("What is your name?");
       if (person != "" && person != null) {
           localStorage.setItem('name', person);
       } else {
          alert("We need your name to load your flower!");
          setTimeout(function(){
                window.location.reload();
            },100);
       } 
    
    $(function() { 
    $(".petal_title").remove();
        $('area').each(function(){

            var txt=$(this).data('name');
            var coor=$(this).attr('coords');
            var maxX = 0,
                minX = Infinity,
                maxY = 0,
                minY = Infinity;
            var i = 0,
                coords = $(this).attr('coords').split(',');

            while (i < coords.length) {
                var x = parseInt(coords[i++],10),
                    y = parseInt(coords[i++],10);

                if (x < minX) minX = x;
                else if (x > maxX) maxX = x;

                if (y < minY) minY = y;
                else if (y > maxY) maxY = y;
            }
            
            if(txt == 'Water') {
                var left = parseInt(coords[1])*1.1;
                var top = coords[0];
                var person = localStorage.getItem('name');
                var txt = person;
            } else if(txt == 'Earth_1'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.1;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Earth_2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.17;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Air_1A'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.1;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Air_2B'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.15;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Air_2A'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.4;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Air_1B'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.2;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_1A1'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.08;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_1A2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.08;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_1B1'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.1;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_1B2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.25;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_2B1'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.07;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_2B2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.1;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_2A2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.35;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else {
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft);
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            }
            var $span=$('<span class="petal_title">'+txt+'</span>');        
            $span.css({top: top+'px', left: left+'px', position:'absolute'});
            $span.appendTo("#lotusmap");
        });
    });

    $('area').on('focus', function(e) {
      e.preventDefault();
      $('.selection p').html($(this).attr('class'));      
    });
     
});

$(window).resize(function() {
    $(".petal_title").remove();
    
    $('area').each(function(){
        var txt=$(this).data('name');
        var coor=$(this).attr('coords');
        var maxX = 0,
            minX = Infinity,
            maxY = 0,
            minY = Infinity;

            var i = 0,
                coords = $(this).attr('coords').split(',');

            while (i < coords.length) {
                var x = parseInt(coords[i++],10),
                    y = parseInt(coords[i++],10);

                if (x < minX) minX = x;
                else if (x > maxX) maxX = x;

                if (y < minY) minY = y;
                else if (y > maxY) maxY = y;
            }
        
        if(txt == 'Water') {
                var left = parseInt(coords[1])*1.1;
                var top = coords[0];
                var person = localStorage.getItem('name');
                var txt = person;
            } else if(txt == 'Earth_1'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.1;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Earth_2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.17;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Air_1A'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.1;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Air_2B'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.15;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Air_2A'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.4;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Air_1B'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.2;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_1A1'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.08;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_1A2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.08;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_1B1'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.1;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_1B2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.25;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_2B1'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.07;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_2B2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.1;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else if(txt == 'Fire_2A2'){         
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft)*1.35;
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            } else {
                var pleft = minX + (maxX - minX) / 2;
                var left = parseInt(pleft);
                var ptop = minY + (maxY - minY) / 2;
                var top = parseInt(ptop);
            }
        var $span=$('<span class="petal_title">'+txt+'</span>');        
        $span.css({top: top+'px', left: left+'px', position:'absolute'});
        $span.appendTo("#lotusmap");
    });
    
});
    

