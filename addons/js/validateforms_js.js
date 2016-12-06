function validateTutorials(){
    if(document.tutorial.name.value==""){
        alert("O campo \"Nome\" foi preenchido incorretamente.");
        document.tutorial.name.focus();
    }else if(document.tutorial.url.value==""){
        alert("O campo \"URL do vídeo\" foi preenchido incorretamente.");
        document.tutorial.url.focus();
    }else if(document.tutorial.description.value=="") {
        alert("O campo \"Descrição\" foi preenchido incorretamente.");
        document.tutorial.description.focus();
    }else{
      removeMasks();
    	return true;
    }
    return false;
}

function validateBrands(){
    if(document.brand.name.value==""){
       alert("O campo \"Nome\" foi preenchido incorretamente.") ;
       document.brand.name.focus();
    }else{
      removeMasks();
    	return true;
    }
    return false;
}

function validateModels(){
	if(document.model.brand.value==""){
		alert("O campo \"Marca\" foi preenchido incorretamente.");
	}else if(document.model.name.value==""){
		alert("O campo \"Nome\" foi preenchido incorretamente.");
		document.model.name.focus();
	}else{
		removeMasks();
		return true;
	}
	return false;
}

function validateClients(){
    if(document.client.rep_name.value==""){
        alert("O campo \"Nome representante\" foi preenchido incorretamente.");
        document.client.rep_name.focus();
    }else if(document.client.city.value=="") {
        alert("O campo \"Cidade\" foi preenchido incorretamente.");
        document.client.city.focus();
    }else if(document.client.neighborhood.value=="") {
        alert("O campo \"Bairro\" foi preenchido incorretamente.");
        document.client.neighborhood.focus();
    }else if(document.client.street.value=="") {
        alert("O campo \"Logradouro\" foi preenchido incorretamente.");
        document.client.street.focus();
    }else if(document.client.street_num.value=="") {
        alert("O campo \"Número\" foi preenchido incorretamente.");
        document.client.street_num.focus();
    }else if(document.client.cep.value=="") {
        alert("O campo \"CEP\" foi preenchido incorretamente.");
        document.client.cep.focus();
    }else if(document.client.username.value=="") {
        alert("O campo \"Usuário\" foi preenchido incorretamente.");
        document.client.username.focus();
    }else if(document.client.password.value=="") {
        alert("O campo \"Senha\" foi preenchido incorretamente.");
        document.client.password.focus();
    }else{
      removeMasks();
    	return true;
    }
    return false;

}

function validateLogin(){
    if(document.login.username.value==""){
        alert("O campo \"Usuário\" foi preenchido incorretamente.");
        document.login.username.focus();
    } else if(document.login.password.value==""){
        alert("O campo \"Senha\" foi preenchido incorretamente.");
        document.login.password.focus();
    } else {
      removeMasks();
    	return true;
    }
    return false;
}

function validatePrinters(){
    if(document.printer.mlt.value==""){
        alert("O campo \"MLT\" foi preenchido incorretamente.");
        document.printer.mlt.focus();
    } else if(document.printer.brand.value==""){
        alert("O campo \"Marca\" foi preenchido incorretamente.");
    } else if(document.printer.model.value==""){
        alert("O campo \"Modelo\" foi preenchido incorretamente.");
    } else {
      removeMasks();
    	return true;
    }
    return false;
}

function validateRentals(){
	if(document.rental.client.value==""){
		alert("O campo \"Cliente\" foi preenchido incorretamente.");
	} else if(document.rental.start_date.value==""){
		alert("O campo \"Data de início\" foi preenchido incorretamente.");
	} else if(document.rental.end_date.value==""){
		alert("O campo \"Data de fim\" foi preenchido incorretamente.");
	} else if(document.rental.page_cap.value==""){
		alert("O campo \"Franquia\" foi preenchido incorretamente.");
		document.rental.page_cap.focus();
	} else if(document.rental.page_cap_price.value==""){
		alert("O campo \"Preço da franquia\" foi preenchido incorretamente.");
		document.rental.page_cap_price.focus();
	} else if(document.rental.bw_price.value==""){
		alert("O campo \"Preço da página monocromática excedida\" foi preenchido incorretamente.");
		document.rental.bw_price.focus();
	} else {
		return validateDetails();
	}
	return false;
}

function validateAdmin(){
	if(document.admin.name.value==""){
		alert("O campo \"Nome de usuário\" foi preenchido incorretamente.");
		document.admin.name.focus();
	} else if(document.admin.password.value==""){
		alert("O campo \"Senha\" foi preenchido incorretamente.");
		document.admin.password.focus();
	} else {
		removeMasks();
		return true;
	}
	return false;
}

function validateCategories(){
	if(document.categories.category.value==""){
		alert("O campo \"Nome da categoria\" foi preenchido incorretamente.");
		document.categories.category.focus();
	}else if(document.categories.priority.value==""){
		alert("O campo \"Prioridade\" foi preenchido incorretamente.");
		document.categories.priority.focus();
	} else {
		removeMasks();
		return true;
	}
	return false;
}

function validateEmployees(){
	if(document.employees.username.value==""){
		alert("O campo \"Usuário\" foi preenchido incorretamente.");
		document.employees.username.focus();
	}else if(document.employees.password.value==""){
		alert("O campo \"Senha\" foi preenchido incorretamente.");
		document.employees.password.focus();
	}else if(document.employees.name.value=="") {
		alert("O campo \"Nome\" foi preenchido incorretamente.");
		document.employees.name.focus();
	}else{
		removeMasks();
		return true;
	}
	return false;
}