<script>
        function verif()
        {

		var Nom = document.getElementById('Nom').value;
		var Prenom = document.getElementById('Prenom').value;
        var Age = document.getElementById('Age').value;
        var Num_tel = document.getElementById('Num_tel').value;
        var Email = document.getElementById('Email').value;
        var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        var errorNom = document.getElementById('errorNom');
		var errorPrenom = document.getElementById('errorPrenom');
		var errorAge = document.getElementById('errorAge');
		var errorNum_tel = document.getElementById('errorNum_tel');
        var errorEmail = document.getElementById('errorEmail');

        if(Nom =="")
        {
            errorNom.innerHTML="Oups!Le nom est vide!";
            return false;
        }
        else
            if(Nom.charAt(0)>="a" && Nom.charAt(0)<="z")
            {
                errorNom.innerHTML="Le nom doit etre commencé par une lettre majuscule !";  
                return false;
            }
            else
            {
                errorNom.innerHTML="";
            }	
            
        if(Prenom =="")
        {
            errorPrenom.innerHTML="Oups!Le prenom est vide!";
            return false;
        }
        else
            if(Nom.charAt(0)>="a" && Nom.charAt(0)<="z")
            {
                errorPrenom.innerHTML="Le prenom doit etre commencé par une lettre majuscule !";  
                return false;
            }
            else
            {
                errorPrenom.innerHTML="";
            }	    


            if (!emailRegex(Email) || Email=="")
            {
                errorEmail.innerHTML = 'Oups!Entrer un email valide';
                return false;
            }
            else
			{
				errorEmail.innerHTML = "";
				
			}

            var aux=Email.substr(Email.indexOf('@'),Email.length)
            if (aux!="@esprit.tn")
            errorEmail.innerHTML="Mail se termine par @esprit.tn!!"

            if(Age=="")
            {
                errorAge.innerHTML="L'age est vide!";  
                return false;
            }
            else 
                if(Age<= 18)
                {
                    errorAge.innerHTML="l'age doit etre superieur à 0 !";  
                    return false;
                }
                else
                {
                    errorAge.innerHTML="";  
                }    

            if(Num_tel=="")
            {
                errorNum_tel.innerHTML="Le numero de telephone est vide!";  
                return false;
            }
            else 
                if(Num_tel= 0)
                {
                    errorNum_tel.innerHTML="Le numero de telephone doit etre superieur à 0 !";  
                    return false;
                }
                else
                {
                    errorNum_tel.innerHTML="";  
                }    


		} 
        </script>


