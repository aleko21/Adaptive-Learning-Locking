
			function createRequestObj(){ // creo un'istanza XMLHttpRequest 
    			var re; 
    			var browser=navigator.appName; 
    			if (browser=="Microsoft Internet Explorer"){ // sniff browser 
        			re=new ActiveXObject("Microsoft.XMLHTTP"); 
    			} else re=new XMLHttpRequest(); 
    			return re; 
			} 
			
			//istanzio questa variabile
			var http=createRequestObj();
			
			//funzione che serve per popolare quando hai scelto
			function popolaElemento(idElDaPopolare, paginaFonteDati, metodo, parametri){ // faccio una richiesta 
    			//alert(parametri); // debug 
    			var url=paginaFonteDati+"?" + parametri 
    			http.open(metodo, url , true) 
    			document.getElementById(idElDaPopolare).innerHTML="<select multiple><option value=\"0\">caricamento in corso...</option></select>"; 
    			http.onreadystatechange=function(){ 
        		if (http.readyState==4 || http.readyState=="complete"){ 
            		if (http.status == 200){ 
                		document.getElementById(idElDaPopolare).innerHTML=http.responseText; 
            		} 
					else { 
                		document.getElementById(idElDaPopolare).innerHTML="<select><option>ERRORE "+http.status+"</option></select>"; 
            			} 
        			} 
					

    			} 
    			
				http.send(null); 
			}