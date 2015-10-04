<script type="text/javascript">
function clear()
{
   document.mykadform.name.value=""; 
   document.mykadform.nric.value=""; 
   document.mykadform.oldic.value=""; 
   document.mykadform.birthplace.value=""; 
   document.mykadform.dob.value=""; 
   document.mykadform.race.value=""; 
   document.mykadform.religion.value=""; 
   document.mykadform.citizenship.value=""; 
   document.mykadform.addr1.value=""; 
   document.mykadform.addr2.value=""; 
   document.mykadform.addr3.value=""; 
   document.mykadform.city.value=""; 
   document.mykadform.postcode.value=""; 
   document.mykadform.state.value=""; 
}

function PopulateForm(data)
{
//	alert(data);
	var dataElement = data.split("|");
	var idx = 0;
	for(idx = 0; idx < dataElement.length; idx++){
		var valuePair = dataElement[idx].split("=");
		
		if (valuePair[0] == "NAME")
		{
			document.mykadform.name.value = valuePair[1]; 
		}else if (valuePair[0] == "NRIC")
		{
			document.mykadform.nric.value = valuePair[1]; 
		}else if (valuePair[0] == "OLDIC")
		{
			document.mykadform.oldic.value = valuePair[1]; 
		}else if (valuePair[0] == "POB")
		{
			document.mykadform.birthplace.value = valuePair[1]; 
		}else if (valuePair[0] == "DOB")
		{
			document.mykadform.dob.value = valuePair[1]; 
		}else if (valuePair[0] == "RACE")
		{
			document.mykadform.race.value = valuePair[1]; 
		}else if (valuePair[0] == "GENDER")
		{
			document.mykadform.gender.value = valuePair[1]; 
		}else if (valuePair[0] == "RELIGION")
		{
			document.mykadform.religion.value = valuePair[1]; 
		}else if (valuePair[0] == "CITIZENSHIP")
		{
			document.mykadform.citizenship.value = valuePair[1]; 
		}else if (valuePair[0] == "ADDR1")
		{
			document.mykadform.addr1.value = valuePair[1]; 
		}else if (valuePair[0] == "ADDR2")
		{
			document.mykadform.addr2.value = valuePair[1]; 
		}else if (valuePair[0] == "ADDR3")
		{
			document.mykadform.addr3.value = valuePair[1]; 
		}else if (valuePair[0] == "CITY")
		{
			document.mykadform.city.value = valuePair[1]; 
		}else if (valuePair[0] == "POSTCODE")
		{
			document.mykadform.postcode.value = valuePair[1]; 
		}else if (valuePair[0] == "STATE")
		{
			document.mykadform.state.value = valuePair[1]; 
		}else if (valuePair[0] == "PHOTO")
		{
//			document.mykadform.photodata.value = valuePair[1]; 
		}
	}
}
</script> 

<form method="get" name="mykadform" onSubmit="submitform()">
<table>
<tr>
<td>Name:</td>
<td>
<input type="text" name="name" value="" maxlength="100" size="48" />
</td>
</tr>
<tr>
<td>New IC:</td>
<td>
<input type="text" name="nric" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td>Old IC:</td>
<td>
<input type="text" name="oldic" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td>Birth Place:</td>
<td>
<input type="text" name="birthplace" value="" maxlength="100" size="48" /></td>
</tr>
<tr>
<td>Date Of Birth:</td>
<td>
<input type="text" name="dob" value="" maxlength="100" size="48" /></td>
</tr>
<tr>
<td>Race:</td>
<td>
<input type="text" name="race" value="" maxlength="100" size="48" /></td>
</tr>
<tr>
<td>Gender:</td>
<td>
<input type="text" name="gender" value="" maxlength="100" size="48" /></td>
</tr>
<tr>
<td>Religion:</td>
<td>
<input type="text" name="religion" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td> Citizenship:</td>
<td>
<input type="text" name="citizenship" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td> Address:</td>
<td>
<input type="text" name="addr1" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td> &nbsp;</td>
<td>
<input type="text" name="addr2" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td> &nbsp;</td>
<td>
<input type="text" name="addr3" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td> City:</td>
<td>
<input type="text" name="city" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td> Postcode:</td>
<td>
<input type="text" name="postcode" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td> State:</td>
<td>
<input type="text" name="state" value="" maxlength="100" size="48" /></td>
</tr>
<tr><td> &nbsp;</td>
<td>
&nbsp;</td>
</tr>
<tr><td> &nbsp;</td>
<td>
<input type="submit" value="Submit" name="btSubmit" /><input type="reset" value="Clear" name="btclear" /></td>
</tr>
<tr><td> </td>
<td>
&nbsp;</td>
</tr>
</table>
<applet name="mykad" code="MyKadForm.class" ARCHIVE="MyKadDemo.jar" width=400 height=120>
</applet>