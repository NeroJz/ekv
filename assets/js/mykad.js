/*
* mykad.js by Intellego Solutions Sdn Bhd
* Copyright 2012 Intellego Solutions Sdn Bhd
* http://www.intellego.com.my
*/

    function clean_hex(input, remove_0x) {
        input = input.toUpperCase();
        
        if (remove_0x) {
          input = input.replace(/0x/gi, "");        
        }
        
        var orig_input = input;
        input = input.replace(/[^A-Fa-f0-9]/g, "");
        if (orig_input != input)
            alert ("Warning! Non-hex characters in input string ignored.");
        return input;    
    }

    var base64_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    function binary_to_base64(input) {
      var ret = new Array();
      var i = 0;
      var j = 0;
      var char_array_3 = new Array(3);
      var char_array_4 = new Array(4);
      var in_len = input.length;
      var pos = 0;
  
      while (in_len--)
      {
          char_array_3[i++] = input[pos++];
          if (i == 3)
          {
              char_array_4[0] = (char_array_3[0] & 0xfc) >> 2;
              char_array_4[1] = ((char_array_3[0] & 0x03) << 4) + ((char_array_3[1] & 0xf0) >> 4);
              char_array_4[2] = ((char_array_3[1] & 0x0f) << 2) + ((char_array_3[2] & 0xc0) >> 6);
              char_array_4[3] = char_array_3[2] & 0x3f;
  
              for (i = 0; (i <4) ; i++)
                  ret += base64_chars.charAt(char_array_4[i]);
              i = 0;
          }
      }
  
      if (i)
      {
          for (j = i; j < 3; j++)
              char_array_3[j] = 0;
  
          char_array_4[0] = (char_array_3[0] & 0xfc) >> 2;
          char_array_4[1] = ((char_array_3[0] & 0x03) << 4) + ((char_array_3[1] & 0xf0) >> 4);
          char_array_4[2] = ((char_array_3[1] & 0x0f) << 2) + ((char_array_3[2] & 0xc0) >> 6);
          char_array_4[3] = char_array_3[2] & 0x3f;
  
          for (j = 0; (j < i + 1); j++)
              ret += base64_chars.charAt(char_array_4[j]);
  
          while ((i++ < 3))
              ret += '=';
  
      }
  
      return ret;
    }

    function hex2a(hex) {
        var str = '';
        for (var i = 0; i < hex.length; i += 2)
            str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
        return str;
    }

    function d2h(d) { return d.toString(16); }
    function h2d(h) { return parseInt(h, 16); }

    function Str2Hex(hex) {
        var tmp = hex;
        var str = '';
        for (var i = 0; i < tmp.length; i++) {
            c = tmp.charCodeAt(i);
            str += d2h(c) + ' ';
        }
        return str;
    }

    function Hex2Str(hex) {
        var tmp = hex;
        var arr = tmp.split(' ');
        var str = '';
        for (var i = 0; i < arr.length; i++) {
            c = String.fromCharCode(h2d(arr[i]));
            str += c;
        }
        return str;
    }

    function HexToDec(hex) {
        try {
            var str1 = hex.substring(6, 8) + hex.substring(4, 6) + hex.substring(2, 4) + hex.substring(0, 2);
            return h2d(str1);

        }
        catch (err) {
            //alert("Javascript Exception: " + err);
        }

    }


function PopulateForm(data)
{
//  alert(data);
    var dataElement = data.split("|");
    var idx = 0;
    for(idx = 0; idx < dataElement.length; idx++){
        var valuePair = dataElement[idx].split("=");
        
        if (valuePair[0] == "NAME")
        {
            $('#begin').val(valuePair[1].replace(/\s+/g, ' ')); 
        }else if (valuePair[0] == "NRIC")
        {
             $('#ic').val(valuePair[1]); 
        }else if (valuePair[0] == "OLDIC")
        {
            //document.mykadform.oldic.value = valuePair[1]; 
        }else if (valuePair[0] == "POB")
        {
            //document.mykadform.birthplace.value = valuePair[1]; 
        }else if (valuePair[0] == "DOB")
        {
             $('#date_of_birth').val(valuePair[1]); 
        }else if (valuePair[0] == "RACE")
        {
             $('#bangsa').val(valuePair[1]); 
        }else if (valuePair[0] == "GENDER")
        {

            if(valuePair[1] == "MALE")
                $('input:radio[name="jantina"]').filter('[value="Lelaki"]').attr('checked', true);
            else
                $('input:radio[name="jantina"]').filter('[value="Perempuan"]').attr('checked', true);

        }else if (valuePair[0] == "RELIGION")
        {
            $('#agama').val(valuePair[1]); 
        }else if (valuePair[0] == "CITIZENSHIP")
        {
            $('#nationality').val(valuePair[1]); 
        }else if (valuePair[0] == "ADDR1")
        {
            $('#address1').val(valuePair[1]); 
        }else if (valuePair[0] == "ADDR2")
        {
             $('#address2').val(valuePair[1]); 
        }else if (valuePair[0] == "ADDR3")
        {
             $('#address3').val(valuePair[1]); 
        }else if (valuePair[0] == "CITY")
        {
            $('#city').val(valuePair[1]); 
        }else if (valuePair[0] == "POSTCODE")
        {
            $('#postcode').val(valuePair[1]); 
        }else if (valuePair[0] == "STATE")
        {
            $('#state').val(valuePair[1]); 
        }else if (valuePair[0] == "PHOTO")
        {
            var hexImage = Str2Hex(valuePair[1]);
            var binaryImage = Hex2Str(hexImage);
            var binary = new Array();
            
            //convert hex to binary
            for (var i=0; i<binaryImage.length/2; i++) {
                var h = binaryImage.substr(i*2, 2);
                binary[i] = parseInt(h,16);        
            }

            var biImgString = binary.toString();

            var b64data = binary_to_base64(binary);
            $("#photo").attr("src", "data:image/jpg;base64,"+b64data);
            $("#rawPhoto").val(b64data);
        }
    }
}