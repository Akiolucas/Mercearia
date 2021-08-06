if(typeof $ === 'undefined'){ // verificar se jquery via CDN foi carregado, caso contrário carregar localmente. 
  var scriptJq = document.createElement("SCRIPT");
  scriptJq.type = 'text/javascript';
  scriptJq.src = "http://localhost/mercearia/app/Assets/jquery/jquery-3.6.0.min.js";
  document.body.appendChild(scriptJq);
  
}
var bootstrapJs = document.createElement("SCRIPT"); // adicionar o script do bootstrap via CDN após o JQUERY.min 
    bootstrapJs.type = 'text/javascript';
    bootstrapJs.src = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    bootstrapJs.integrity = "sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns";
    bootstrapJs.setAttribute('crossorigin', "anonymous");
    document.body.appendChild(bootstrapJs);

  document.body.onload = carregarBootstrap;
 
function carregarBootstrap(){

  if(typeof($.fn.modal) === 'undefined'){ // verificar se bootstrap JS via CDN foi  carregado, caso contrário carregar localmente.
    var localBootstrap = document.createElement("SCRIPT");
    localBootstrap.type = 'text/javascript';
    localBootstrap.src = "http://localhost/mercearia/app/Assets/bootstrap/js/bootstrap.bundle.min.js";
    document.body.appendChild(localBootstrap);
    
  }
 
}

