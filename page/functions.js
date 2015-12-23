function showInput(){
	var company = document.getElementById('company_info');
	if(document.forms[0].user_group.value == "3"){
		company.style.display="inline";
	}else{
		company.style.display="none";
	}
}