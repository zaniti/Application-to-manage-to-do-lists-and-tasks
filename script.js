function cheeck(vall,record_id) {
    var checkBox = document.getElementsByClassName("checkboox");
    var text= document.getElementsByClassName("text");

    for (let i = 0 ; i<checkBox.length ; i++){
        if (checkBox[i].value == 1 && checkBox[i].name == record_id){

            text[i].style.textDecoration = 'none';
            checkBox[i].value = 0;



     $.post( 'php.php' , { checked : '0', r_id : record_id },
       function( response ) {
        //  alert(response);
        //  $( "#result" ).html( response );
       }
    );


          } else if(checkBox[i].value == 0 && checkBox[i].name == record_id) {
            text[i].style.textDecoration = 'line-through';
            checkBox[i].value = 1;



     $.post( 'php.php' , { checked : '1', r_id : record_id },
       function( response ) {
        //  alert(response);
        //  $( "#result" ).html( response );
       }
    );



  }

          }

    }
