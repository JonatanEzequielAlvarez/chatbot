<!DOCTYPE html>
<html lang="es">

<head>
    
 
   <link rel="shortcut icon"  type="image/x-icon" href="" >
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Bot de reclamos vecinales, versión Beta.">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <title>Reclamos Vecinales - Beta</title>
 

 <script src="https://kit.fontawesome.com/420fa0209e.js" crossorigin="anonymous"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <!-- Global site tag (gtag.js) - Google Analytics -->


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
 
 <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>


  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

   <link href="https://fonts.googleapis.com/css?family=Lato|Questrial|Roboto+Condensed&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato|Questrial&display=swap" rel="stylesheet">      
<link href="https://fonts.googleapis.com/css?family=Special+Elite&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Oswald|Special+Elite&display=swap" rel="stylesheet">   
<link href="https://fonts.googleapis.com/css?family=Questrial&display=swap" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

</head>

<body style="background-image:url(./backn.PNG);  
  background-attachment: fixed;background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover; /* Resize the background image to cover the entire container */height:100%" >

<br>

 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!----voces----->
<script src="https://crear.net.ar/CLIENTES/PLAY/Play/jquery.js"></script>
<script src="https://crear.net.ar/CLIENTES/PLAY/Play/voces.js"></script>
<!----voces----->

 <script>
      // code needs refactoring
$(document).ready(function () {


  
   
      let long;
      let lat;
      let tempDes = $(".temp-desc");
      let location = $(".location");

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
          long = position.coords.longitude;
          lat = position.coords.latitude;
          
          console.log(long);
          console.log(lat);
          console.log(city);
          $('#lat').val(lat);
          $('#long').val(long);
        

       
        });
      }
  
  

});

  </script>

<script>
$(document).keypress(function (e) {
    if (e.which == 13) {
         
         //burbuja();
      var ver = document.getElementById("validate");
      if(ver.innerText == ""){
        //ver.innerText="hola";
        search();
      }else{

       
        var divsLeft = document.getElementsByClassName("question");
                var total2 = divsLeft.length;
              console.log(total2);
       search2(total2 - 1);
      }
       
       
       
    }
});
</script>



<script>
   $.ajax({
  url: "https://geolocation-db.com/jsonp",
  jsonpCallback: "callback",
  dataType: "jsonp",
  success: function(location) {
   
    
    $('#city').val(location.city);
    
  }
});
</script>



<script>
    function burbuja(){
        var $bubblesLeft = $("<div/>", {
      class: "chat-bubble-left"
    }).append([
      $("<div/>", {
        class: "typing"
      }).append([
        $("<div/>", {
          class: "dot"
        }),
        $("<div/>", {
          class: "dot"
        }),
        $("<div/>", {
          class: "dot"
        })
      ])
    ]); 
         // GREETING MESSAGE
//$("#container2").css("display", "none");
 $(".left-msg").css("display", "none");
  
  setTimeout(function () {
    $(".chat-bubble-left").hide();
     //$("#container2").css("display", "block");
     $(".left-msg").css("display", "block");
    
  }, 0000);
    }
    
   
</script>
<div class="d-grid gap-3" >
     <div class="p-2">
          <p style="font-family: 'Lato', sans-serif;color:#fff">📞  <span class="green-dot fas fa-circle" aria-hidden="true" ></span> En línea</p> 
          </div>
          </div>
          
   <div class="form-group" style="display:none">
    
    <input type="text" class="form-control" id="city" name="" required="" style="font-family: 'Lato', sans-serif;border:none;background:transparent;color:#fff" readonly>
    
  </div>  
        
           <div class="left-msg" style="width:90%;max-width:1400px;margin-top:-20px">
         <b><p style="color:#615b5b !important;font-family: 'Lato', sans-serif; font-size:14px">
             ¡Bienvenido/a! Reporta problemas vecinales y de servicios públicos. 
             <span class="info-link" onclick="showWelcomeInfo()" style="color:#237548;cursor:pointer;text-decoration:underline;">📋 Ver reglas</span>
             </p></b>
         
          <span id="spanResponse" style="display:none">0</span>
        </div>
        
        <!-- Popup de bienvenida -->
        <div id="welcomePopup" class="welcome-popup">
            <div class="welcome-content">
                <button class="welcome-close" onclick="hideWelcomeInfo()">&times;</button>
                <div class="welcome-title">📋 Reglas para Reclamos Vecinales</div>
                <div class="welcome-rules">
                    <ol>
                        <li><strong>Servicios públicos:</strong> Deben ser reclamos sobre servicios públicos (baches, semáforos, alumbrado, contenedores de basura, etc.).</li>
                        <li><strong>Lenguaje apropiado:</strong> No deben contener lenguaje ofensivo, insultos o amenazas.</li>
                        <li><strong>Descriptivo y constructivo:</strong> Deben ser descriptivos y constructivos para mejorar los servicios.</li>
                        <li><strong>Sin ataques personales:</strong> No deben incluir ataques personales hacia funcionarios o vecinos.</li>
                        <li><strong>Imágenes:</strong> Puedes adjuntar imágenes que documenten el problema.</li>
                    </ol>
                    <p style="margin-top: 20px; font-style: italic; color: #666;">
                        <strong>Importante:</strong> Todos los reclamos deben incluir ubicación exacta (dirección, intersección o referencia clara) para ser procesados.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Modal de error de imagen -->
        <div id="errorModal" class="welcome-popup">
            <div class="welcome-content">
                <button class="welcome-close" onclick="hideErrorModal()">&times;</button>
                <div class="welcome-title" style="color: #d32f2f;">⚠️ Imagen No Válida</div>
                <div class="welcome-rules">
                    <div id="errorMessage" style="color: #333; line-height: 1.6;">
                        <!-- El mensaje de error se insertará aquí -->
                    </div>
                    <p style="margin-top: 20px; font-style: italic; color: #666;">
                        <strong>Recuerda:</strong> Solo se permiten imágenes que documenten problemas vecinales o de servicios públicos.
                    </p>
                </div>
            </div>
        </div>
          
          <br><br><br>
       
        <div class="" style="float:right;width:96%;max-width:800px">
        <div class="question">
     
     <div class="input-container">
         <input type="search" class="baloon" id="search" name="search" placeholder="Describe tu reclamo vecinal: bache, semáforo dañado, contenedor roto, etc." style="width:100%;font-family: 'Lato', sans-serif;padding-right:120px;"/> 
         <input type="file" id="imageInput" accept="image/*" style="display:none" onchange="handleImageSelect(this)">
         <div class="input-buttons">
             <span class="material-icons attach-btn" onclick="document.getElementById('imageInput').click();" title="Adjuntar imagen">attach_file</span>
             <span class="material-icons send-btn" onclick="search();" title="Enviar">send</span>
         </div>
     </div>
     <span id="validate" style="display:none"></span>
     <div id="imagePreview" style="margin-top:10px;display:none;">
         <img id="previewImg" style="max-width:200px;max-height:200px;border-radius:10px;">
         <span onclick="removeImage()" style="cursor:pointer;color:#fff;margin-left:10px;">❌</span>
     </div>
     <br>
</div>
</div>


<br><br><br>
     
 <audio  id="sonidoNotificacion" class="audio" >
    <source src="https://crear.net.ar/CLIENTES/MBEER/MBeerWeb/iphone-notificacion.mp3" type="audio/mpeg">
    </audio>
    
     <div id="container2">
     
      </div>
           <br>  <br>  <br>
 
        <script>

function guardarPedidoOracion(message, user_message, enabled, image_path = null){
    const params = { message, user_message, enabled };
    if (image_path) {
        params.image_path = image_path;
    }
    
    console.log("Enviando a saveClaim:", params);
    
    fetch("saveClaim.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams(params),
    })
    .then(response => response.json())
    .then(json => {
        console.log("Respuesta de saveClaim:", json);
        if (json.status == "200") {
            console.log("✅ Reclamo guardado correctamente con ID:", json.id)
        } else {
            console.log("❌ Error al guardar:", json.error)
        }
    })
    .catch(error => {
        console.log("error")
    });
}

function search(){
    var ver = document.getElementById("validate");
    if(ver.innerText == ""){
        ver.innerText="hola";
       
        let template2 = `<div id="container2" >
            <div class="left-msg" style="width:90%;max-width:1400px;" id="espera">
                <!-- SEARCH -->
                <b><p style="color:#000 !important;font-family: 'Lato', sans-serif">Procesando reclamo...</p></b>
                <span id="spanResponse2" style="display:none">0</span>
            </div>
        </div>
        <br><br>`;
      
        $('#container2').append(template2);
      
        // Primero subir imagen si existe
        console.log("🔄 Iniciando proceso de imagen...");
        uploadImage().then(imagePath => {
            console.log("📸 Resultado de uploadImage:", imagePath);
     
            var inBuscar = document.getElementById("search").value;
            var spanResponse = document.getElementById("spanResponse").innerHTML;
            
            let data = {
                Question : inBuscar,
                ImagePath: imagePath
            };
            
            console.log("📤 Enviando datos a turbo.php:", data);
            
              $.ajax(
        {
            type: "POST",
            url: "turbo.php",
            data: data,
            success: function (data)
            {
                let user = JSON.parse(data);
                var divsLeft = document.getElementsByClassName("question");
                var total = divsLeft.length;
              console.log(total);
              console.log(data);
              //aca debo contar la cantidad de <p> y pasarlo en la function search2
                if(!data.error) {
                    document.getElementById("espera").style="display:none";
                    $('#container2').append("");
            let tasks = JSON.parse(data);
           
             let responseChat = tasks[0].response
             console.log(responseChat)
            var text = responseChat;
            //responsiveVoice.speak(text, "Spanish Latin American Female");
            text = encodeURIComponent(text);
            let template = '';
            let enabled = false;
            if(responseChat.includes("Reclamo válido y registrado")){
                enabled = true;
            }
            console.log("ResponseChat:", responseChat, "Enabled:", enabled)
            guardarPedidoOracion(responseChat, inBuscar, enabled, imagePath)
            
            // Limpiar imagen después de enviar
            removeImage();
            if(user.length > 0){
               document.getElementById('sonidoNotificacion').play();
            tasks.forEach(task => {
              template += `
              

              <div id="container2" >
     <div class="left-msg" style="width:90%;max-width:1400px;">
              <!-- SEARCH -->
             
              <b><p style="color:#000 !important;font-family: 'Lato', sans-serif">${task.response}</p></b>
              <span id="spanResponse2" style="display:none">${task.id}</span>
            </div>
      </div>

      <div class="" style="float:right;width:96%;max-width:800px">
        <div class="question">
     
        <div class="input-container">
            <input type="search" class="baloon" id="search${total}" name="search" placeholder="Describe tu reclamo vecinal: bache, semáforo dañado, contenedor roto, etc." autofocus="autofocus" style="width:100%;font-family: 'Lato', sans-serif;padding-right:120px;"/> 
            <input type="file" id="imageInput${total}" accept="image/*" style="display:none" onchange="handleImageSelect${total}(this)">
            <div class="input-buttons">
                <span class="material-icons attach-btn" onclick="document.getElementById('imageInput${total}').click();" title="Adjuntar imagen">attach_file</span>
                <span class="material-icons send-btn" onclick="search2(${total});" title="Enviar">send</span>
            </div>
        </div>
        <div id="imagePreview${total}" style="margin-top:10px;display:none;">
            <img id="previewImg${total}" style="max-width:200px;max-height:200px;border-radius:10px;">
            <span onclick="removeImage${total}()" style="cursor:pointer;color:#fff;margin-left:10px;">❌</span>
        </div>
        <br>
</div>
</div>

<br><br>


                  `;
                    });
                    $('#container2').append(template);
                } else {
                    document.getElementById('sonidoNotificacion').play();
                    let template = `
                        <div id="container2">
                            <div class="left-msg" style="width:90%;max-width:1400px">
                                <b><p style="color:#000 !important;font-family: 'Lato', sans-serif">LO SIENTO, NO ENTIENDO</p></b>
                            </div>
                        </div>
                        <div class="" style="float:right;width:96%;max-width:800px">
                            <div class="question">
                                <div class="input-container">
                                    <input type="search" class="baloon" id="search${total}" name="search" placeholder="Describe tu reclamo vecinal: bache, semáforo dañado, contenedor roto, etc." autofocus="autofocus" style="width:100%;font-family: 'Lato', sans-serif;padding-right:120px;"/> 
                                    <input type="file" id="imageInput${total}" accept="image/*" style="display:none" onchange="handleImageSelect${total}(this)">
                                    <div class="input-buttons">
                                        <span class="material-icons attach-btn" onclick="document.getElementById('imageInput${total}').click();" title="Adjuntar imagen">attach_file</span>
                                        <span class="material-icons send-btn" onclick="search2(${total});" title="Enviar">send</span>
                                    </div>
                                </div>
                                <div id="imagePreview${total}" style="margin-top:10px;display:none;">
                                    <img id="previewImg${total}" style="max-width:200px;max-height:200px;border-radius:10px;">
                                    <span onclick="removeImage${total}()" style="cursor:pointer;color:#fff;margin-left:10px;">❌</span>
                                </div>
                                <br>
                            </div>
                        </div>
                        <br><br>
                    `;
                    $('#container2').append(template);
                }
            } else {
                var divsLeft = document.getElementsByClassName("question");
                var total2 = divsLeft.length;
                console.log(total2);
                search2(total2);
            }
        }, // fin success function
        error: function(xhr, status, error) {
            console.error('Error en AJAX:', error);
            document.getElementById("espera").style="display:none";
        }
    });  // fin $.ajax
    
        }).catch(error => {
          console.error('Error al subir imagen:', error);
          // Limpiar todo para permitir intentar de nuevo
          resetChatState();
      });

 }
}

          </script>




<script>
            function search2(total){
             
             let template2 = `<div id="container2" >
     <div class="left-msg" style="width:90%;max-width:1400px;" id="espera${total}">
              <!-- SEARCH -->
             
              <b><p style="color:#000 !important;font-family: 'Lato', sans-serif">Procesando reclamo...</p></b>
              <span id="spanResponse2" style="display:none">0</span>
            </div>
      </div>
      <br><br>`;
      
      $('#container2').append(template2);
      
      // Primero subir imagen si existe
      uploadImageFromInput(total).then(imagePath => {
             
                var inBuscar = document.getElementById("search" + total).value;
                var spanResponse = document.getElementById("spanResponse2").innerHTML;
            
                let data = {
                    Question : inBuscar,
                    Id : spanResponse,
                    ImagePath: imagePath
                };
            
              $.ajax(
        {
            type: "POST",
            url: "turbo.php",
            data: data,
            success: function (data)
            {
              
              let user = JSON.parse(data);
                document.getElementById("espera"+total).style="display:none";
                    $('#container2').append("");
                var divsLeft = document.getElementsByClassName("question");
                var total2 = divsLeft.length;
              console.log(total2);
                if(!data.error) {
                   
                    
            let tasks = JSON.parse(data);
             let response = tasks[0].response
            var text = response;
            //responsiveVoice.speak(text, "Spanish Latin American Female");
            text = encodeURIComponent(text);
            let template = '';
            let enabled = false;
            if(response.includes("Reclamo válido y registrado")){
                enabled = true;
            }
            console.log("Response:", response, "Enabled:", enabled)
            guardarPedidoOracion(response, inBuscar, enabled, imagePath)
            if(user.length > 0){
               document.getElementById('sonidoNotificacion').play();  
               
            tasks.forEach(task => {
              template += `

              <div id="container2">
     <div class="left-msg" style="width:90%;max-width:1400px">
              <!-- SEARCH -->
             
              <b><p style="color:#000;font-family: 'Lato', sans-serif">${task.response}</p><b>
               <span id="spanResponse2" style="display:none">${task.id}</span>
            </div>
      </div>

      <div class="" style="float:right;width:96%;max-width:800px">
        <div class="question">
     
        <div class="input-container"><input type="search" class="baloon" id="search${total2}" name="search" placeholder="Describe tu reclamo vecinal: bache, semáforo dañado, contenedor roto, etc." autofocus="autofocus" style="width:100%;font-family: 'Lato', sans-serif;padding-right:120px;"/> 
        <input type="file" id="imageInput${total2}" accept="image/*" style="display:none" onchange="handleImageSelect${total2}(this)">
        <div class="input-buttons"><span class="material-icons attach-btn" onclick="document.getElementById('imageInput${total2}').click();" title="Adjuntar imagen">attach_file</span><span class="material-icons send-btn" onclick="search2(${total2});" title="Enviar">send</span></div>
        </div></div><div id="imagePreview${total2}" style="margin-top:10px;display:none;">
            <img id="previewImg${total2}" style="max-width:200px;max-height:200px;border-radius:10px;">
            <span onclick="removeImage${total2}()" style="cursor:pointer;color:#fff;margin-left:10px;">❌</span>
        </div>
        <br>
</div>
</div>

<br><br>


                  ` 
           });
           $('#container2').append(template);
          
           
             }else
             
             {
                 document.getElementById('sonidoNotificacion').play();  
              let template = '';
            //tasks.forEach(task => {
              template += `


              <div id="container2">
     <div class="left-msg" style="width:90%;max-width:1400px">
              <!-- SEARCH -->
             
              <b><p style="color:#000;font-family: 'Lato', sans-serif">LO SIENTO, NO ENTIENDO</p><b>
              
            </div>
      </div>

      <div class="" style="float:right;width:96%;max-width:800px">
        <div class="question">
     
        <div class="input-container"><input type="search" class="baloon" id="search${total2}" name="search" placeholder="Describe tu reclamo vecinal: bache, semáforo dañado, contenedor roto, etc." autofocus="autofocus" style="width:100%;font-family: 'Lato', sans-serif;padding-right:120px;"/> 
        <input type="file" id="imageInput${total2}" accept="image/*" style="display:none" onchange="handleImageSelect${total2}(this)">
        <div class="input-buttons"><span class="material-icons attach-btn" onclick="document.getElementById('imageInput${total2}').click();" title="Adjuntar imagen">attach_file</span><span class="material-icons send-btn" onclick="search2(${total2});" title="Enviar">send</span></div>
        </div></div><div id="imagePreview${total2}" style="margin-top:10px;display:none;">
            <img id="previewImg${total2}" style="max-width:200px;max-height:200px;border-radius:10px;">
            <span onclick="removeImage${total2}()" style="cursor:pointer;color:#fff;margin-left:10px;">❌</span>
        </div>
        <br>
</div>
</div>

<br><br>


            ` 
            $('#container2').append(template);
          }
                }
         
          
               
            }
        }
    );
    
    }).catch(error => {
        console.error('Error al subir imagen en search2:', error);
        // Limpiar estado si hay error con imagen
        document.getElementById("espera" + total).style = "display:none";
    });

}

        
        </script>
        
        <script>
        let selectedImage = null;
        
        // Funciones globales para manejar múltiples instancias de imagen
        function handleImageSelect(input) {
            const file = input.files[0];
            if (file) {
                // Validar tamaño (máximo 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showErrorModal('La imagen es demasiado grande. El tamaño máximo permitido es 5MB.<br><br><strong>Por favor:</strong> Selecciona una imagen más pequeña.');
                    return;
                }
                
                console.log("📁 Archivo seleccionado:", file.name, "Tamaño:", file.size);
                
                // Obtener ID base del input (ej: imageInput5 -> 5)
                const baseId = input.id.replace('imageInput', '');
                const previewId = 'previewImg' + baseId;
                const previewContainerId = 'imagePreview' + baseId;
                
                // Mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                    document.getElementById(previewContainerId).style.display = 'block';
                };
                reader.readAsDataURL(file);
                
                // Guardar archivo en propiedad personalizada del input
                input.selectedFile = file;
                
                // Para el input principal, también actualizar selectedImage
                if (input.id === 'imageInput') {
                    selectedImage = file;
                    console.log("✅ selectedImage actualizada para input principal");
                }
                
                console.log("✅ Archivo guardado en input.selectedFile");
            }
        }
        
        function removeImage() {
            selectedImage = null;
            document.getElementById('imageInput').value = '';
            document.getElementById('imagePreview').style.display = 'none';
        }
        
        // Función para crear handlers dinámicos
        function createImageHandlers(id) {
            window['handleImageSelect' + id] = function(input) {
                handleImageSelect(input);
            };
            
            window['removeImage' + id] = function() {
                const inputId = 'imageInput' + id;
                const previewId = 'imagePreview' + id;
                const input = document.getElementById(inputId);
                
                if (input) {
                    input.selectedFile = null;
                    input.value = '';
                    document.getElementById(previewId).style.display = 'none';
                }
            };
        }
        
        // Crear handlers para instancias dinámicas
        for (let i = 1; i <= 20; i++) {
            createImageHandlers(i);
        }
        
        // Funciones para el popup de bienvenida
        function showWelcomeInfo() {
            document.getElementById('welcomePopup').style.display = 'flex';
        }
        
        function hideWelcomeInfo() {
            document.getElementById('welcomePopup').style.display = 'none';
        }
        
        // Funciones para el modal de error
        function showErrorModal(message) {
            document.getElementById('errorMessage').innerHTML = message;
            document.getElementById('errorModal').style.display = 'flex';
        }
        
        function hideErrorModal() {
            document.getElementById('errorModal').style.display = 'none';
        }
        
        // Cerrar popups al hacer clic fuera de ellos
        document.addEventListener('click', function(event) {
            const welcomePopup = document.getElementById('welcomePopup');
            const errorModal = document.getElementById('errorModal');
            
            if (event.target === welcomePopup) {
                hideWelcomeInfo();
            }
            
            if (event.target === errorModal) {
                hideErrorModal();
            }
        });
        
        function resetChatState() {
            // Limpiar imagen
            removeImage();
            // Limpiar input de texto
            document.getElementById("search").value = "";
            // Resetear estado de validación
            document.getElementById("validate").innerText = "";
            
            // Limpiar completamente el área de mensajes de procesando
            // Buscar y eliminar todos los elementos de "procesando"
            var esperaElements = document.querySelectorAll('[id^="espera"]');
            esperaElements.forEach(function(element) {
                element.style.display = "none";
                element.remove();
            });
            
            // También buscar por texto "Procesando reclamo"
            var processingMessages = document.querySelectorAll('.left-msg');
            processingMessages.forEach(function(element) {
                if (element.innerText.includes('Procesando reclamo')) {
                    element.style.display = "none";
                    element.remove();
                }
            });
            
            console.log("Estado del chat reseteado completamente");
        }
        
        function uploadImage() {
            return new Promise((resolve, reject) => {
                console.log("🔍 uploadImage() iniciada, selectedImage:", selectedImage);
                
                // Verificar si hay imagen en el input principal
                const mainImageInput = document.getElementById('imageInput');
                const selectedFile = mainImageInput ? mainImageInput.selectedFile : null;
                
                console.log("🔍 Verificando input principal, selectedFile:", selectedFile);
                
                if (!selectedImage && !selectedFile) {
                    console.log("📭 No hay imagen seleccionada, resolviendo null");
                    resolve(null);
                    return;
                }
                
                // Usar selectedFile si selectedImage es null
                const fileToUpload = selectedImage || selectedFile;
                console.log("📁 Archivo a subir:", fileToUpload ? fileToUpload.name : "null");
                
                console.log("🔍 Validando imagen antes de procesar texto...");
                console.log("📁 Archivo a validar:", fileToUpload.name, "Tamaño:", fileToUpload.size);
                
                const formData = new FormData();
                formData.append('image', fileToUpload);
                
                console.log("📤 Enviando imagen a validarImagen.php...");
                
                fetch('validarImagen.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log("📥 Respuesta recibida de validarImagen.php");
                    return response.json();
                })
                .then(data => {
                    console.log("📸 Respuesta de validación de imagen:", data);
                    
                    if (data.status === 'success') {
                        console.log("✅ Imagen válida, continuando con procesamiento...");
                        console.log("📂 Ruta de imagen guardada:", data.path);
                        resolve(data.path);
                    } else if (data.status === 'invalid') {
                        console.log("❌ Imagen no válida:", data.message);
                        showErrorModal('<strong>Imagen no válida:</strong><br><br>' + data.message + '<br><br><strong>Por favor:</strong> Selecciona una imagen que documente un problema vecinal o de servicios públicos.');
                        // Limpiar todo y permitir intentar de nuevo
                        resetChatState();
                        reject(data.message);
                    } else {
                        console.log("❌ Error en validación:", data.message);
                        showErrorModal('<strong>Error al procesar imagen:</strong><br><br>' + data.message + '<br><br><strong>Por favor:</strong> Intenta con otra imagen.');
                        // Limpiar todo y permitir intentar de nuevo
                        resetChatState();
                        reject(data.message);
                    }
                })
                .catch(error => {
                    console.log("❌ Error al validar imagen:", error);
                    showErrorModal('<strong>Error al validar imagen:</strong><br><br>No se pudo procesar la imagen. Por favor, intenta nuevamente.<br><br><strong>Posibles causas:</strong><br>• Problema de conexión<br>• Formato de imagen no soportado<br>• Archivo corrupto');
                    // Limpiar todo para permitir intentar de nuevo
                    resetChatState();
                    reject(error);
                });
            });
        }
        
        // Función para subir imagen desde cualquier input dinámico
        function uploadImageFromInput(inputId) {
            return new Promise((resolve, reject) => {
                const imageInput = document.getElementById('imageInput' + inputId);
                const selectedFile = imageInput ? imageInput.selectedFile : null;
                
                if (!selectedFile) {
                    resolve(null);
                    return;
                }
                
                console.log("🔍 Validando imagen del input", inputId, "antes de procesar texto...");
                
                const formData = new FormData();
                formData.append('image', selectedFile);
                
                fetch('validarImagen.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("📸 Respuesta de validación de imagen del input", inputId, ":", data);
                    
                    if (data.status === 'success') {
                        console.log("✅ Imagen válida del input", inputId, ", continuando...");
                        // Limpiar imagen después de subir exitosamente
                        if (window['removeImage' + inputId]) {
                            window['removeImage' + inputId]();
                        }
                        resolve(data.path);
                    } else if (data.status === 'invalid') {
                        console.log("❌ Imagen no válida del input", inputId, ":", data.message);
                        showErrorModal('<strong>Imagen no válida:</strong><br><br>' + data.message + '<br><br><strong>Por favor:</strong> Selecciona una imagen que documente un problema vecinal o de servicios públicos.');
                        reject(data.message);
                    } else {
                        console.log("❌ Error en validación del input", inputId, ":", data.message);
                        showErrorModal('<strong>Error al procesar imagen:</strong><br><br>' + data.message + '<br><br><strong>Por favor:</strong> Intenta con otra imagen.');
                        reject(data.message);
                    }
                })
                .catch(error => {
                    console.log("❌ Error al validar imagen del input", inputId, ":", error);
                    showErrorModal('<strong>Error al validar imagen:</strong><br><br>No se pudo procesar la imagen. Por favor, intenta nuevamente.<br><br><strong>Posibles causas:</strong><br>• Problema de conexión<br>• Formato de imagen no soportado<br>• Archivo corrupto');
                    reject(error);
                });
            });
        }
        </script>
        
        <script>
    //         function alerta(){
         
  
    //             var lat = document.getElementById("lat").value;
    //             var long = document.getElementById("long").value;
               
    //       let data =
    //         {
    //             lat : lat,
    //             long : long
               
    //         };
            
    //           $.ajax(
    //     {
    //         type: "POST",
    //         url: "/ChatBot/alarma.php",
    //         data: data,
    //         success: function (data)
    //         {
    //              let dato = JSON.parse(data);
    //             var status = dato[0].status;
    //           console.log(status);
    //           console.log(data);
    //           //aca debo contar la cantidad de <p> y pasarlo en la function search2
    //             if(!data.error) {
            
    //         if(status=="200"){
    //           swal({
    //             title: "OK",
    //             html: "Hemos registrado tu alarma de ayuda",
    //             type: "success",
    //             showCancelButton: false,
    //             showConfirmButton: true,
    //             cancelButtonColor: "#DD6B55",
    //             confirmButtonColor: "#DD6B55",


    //         });
            
    //             }else{
    //                  swal({
    //             title: "LO SIENTO",
    //             html: "Algo salio mal",
    //             type: "warning",
    //             showCancelButton: false,
    //             showConfirmButton: true,
    //             cancelButtonColor: "#DD6B55",
    //             confirmButtonColor: "#DD6B55",


    //         });
    //             }
         
               
    //             }  else{
    //                   swal({
    //             title: "LO SIENTO",
    //             html: "Algo salio mal",
    //             type: "warning",
    //             showCancelButton: false,
    //             showConfirmButton: true,
    //             cancelButtonColor: "#DD6B55",
    //             confirmButtonColor: "#DD6B55",


    //         });
    //             } 
    //         }
    //     }
        
    // )
    
    //     }  
            


            
        </script>
        
        
        <style>
            /* Estilos para el contenedor de input mejorado */
            .input-container {
                position: relative;
                width: 100%;
                max-width: 800px;
            }
            
            /* Estilos para el popup de bienvenida */
            .welcome-popup {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                z-index: 1000;
                justify-content: center;
                align-items: center;
            }
            
            .welcome-content {
                background: white;
                padding: 30px;
                border-radius: 15px;
                max-width: 500px;
                width: 90%;
                max-height: 80vh;
                overflow-y: auto;
                position: relative;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            }
            
            .welcome-close {
                position: absolute;
                top: 10px;
                right: 15px;
                font-size: 24px;
                cursor: pointer;
                color: #666;
                background: none;
                border: none;
                padding: 5px;
            }
            
            .welcome-close:hover {
                color: #000;
            }
            
            .welcome-title {
                color: #237548;
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 20px;
                text-align: center;
            }
            
            .welcome-rules {
                color: #333;
                font-size: 14px;
                line-height: 1.6;
            }
            
            .welcome-rules ol {
                padding-left: 20px;
            }
            
            .welcome-rules li {
                margin-bottom: 10px;
            }
            
            .info-link:hover {
                color: #1a5a3a !important;
            }
            
            .input-buttons {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                display: flex;
                gap: 10px;
                align-items: center;
            }
            
            .attach-btn, .send-btn {
                color: #fff !important;
                cursor: pointer;
                padding: 8px;
                border-radius: 50%;
                transition: all 0.3s ease;
                background-color: rgba(255, 255, 255, 0.1);
            }
            
            .attach-btn:hover, .send-btn:hover {
                background-color: rgba(255, 255, 255, 0.2);
                transform: scale(1.1);
            }
            
            .attach-btn {
                font-size: 20px !important;
            }
            
            .send-btn {
                font-size: 24px !important;
            }
            
            /* Responsive para móviles */
            @media only screen and (max-width: 600px) {
                .input-buttons {
                    right: 5px;
                    gap: 5px;
                }
                
                .attach-btn, .send-btn {
                    padding: 6px;
                    font-size: 18px !important;
                }
                
                .send-btn {
                    font-size: 22px !important;
                }
                
                #busqueda {
                    margin-top:-650px !important;
                    z-index:9999 !important;
                }
            }
            
            @media only screen and (min-width: 605px) {
                #busqueda {
                    margin-top:850px !important;
                }
            }
        </style>
        
      
      

      <style>
      

}

:root {
  --main-blue: #237548;
  --main-light-blue: #237548;
}

* {
  box-sizing: border-box;
  padding: 0;
  margin: 0;
}

ul {
  list-style-type: none;
}

.typing {
  align-items: center;
  display: flex;
  height: 17px;
}

.typing .dot {
  animation: mercuryTypingAnimation 1.8s infinite ease-in-out;
  background-color: gray;
  border-radius: 50%;
  height: 7px;
  margin-right: 4px;
  vertical-align: middle;
  width: 7px;
  display: inline-block;
}

.typing .dot:nth-child(1) {
  animation-delay: 200ms;
}

.typing .dot:nth-child(2) {
  animation-delay: 300ms;
}

.typing .dot:nth-child(3) {
  animation-delay: 400ms;
}

.typing .dot:last-child {
  margin-right: 0;
}
body {
  font-family: "Roboto", sans-serif;
  width: 100%;
  height: 100%;
 
  font-weight: 400;
}



.screen {
  height: 100vh;
  width: 100%;
  background-color: white;
  margin: 0 auto;
}

.blue-alert {
  position: fixed;
  top: 0;
  width: 100%;
  padding: 0.8rem;
  background-color: var(--main-blue);
  overflow: hidden;
  color: white;
  font-size: 1.4rem;
}

.blue-alert p {
  margin-left: 1rem;
}

.main-top {
  position: fixed;
  top: 3rem;
  width: 100%;
  display: grid;
  grid-template-columns: 5% 40% auto 5% 5%;
  padding: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 0.1rem solid #f2f2f2;
}

.img img {
  width: 70%;
  border-radius: 50%;
  transition: transform 0.5s;
}
/* TYPING ANIMATION */
.chat-bubble-left {
  background-color: #f1f0f0;
  padding: 1rem;
  border-radius: 5rem;
  display: table;
  margin: 0.5rem auto 0.5rem 2rem;
}

.img img:hover {
  position: relative;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  -ms-transform: scale(2);
  /* IE 9 */
  -webkit-transform: scale(2);
  /* Safari 3-8 */
  transform: scale(3) translate(0.8rem);
}

.name {
  font-size: 1.2rem;
}

.letter-anim:hover {
  color: var(--main-blue);
}

.green-dot {
  font-size: 0.6rem;
  color: #42b72a;
}

.name p {
  color: #868686;
  font-size: 1rem;
}

.weather {
  font-weight: normal;
  font-size: 0.9rem;
  line-height: 0.2;
}

#wicon {
  margin-left: 1rem;
}

.icon {
  padding: 0.75rem;
  font-size: 2rem;
  color: var(--main-light-blue);
  text-align: center;
  cursor: pointer;
}

.icon:hover {
  opacity: 0.8;
}

.call {
  position: relative;
}

.call .contact-details {
  visibility: hidden;
  width: auto;
  background-color: #fff;
  color: #000;
  text-align: center;
  border-radius: 6px;
  padding: 0.5rem;
  position: absolute;
  z-index: 11;
  top: 100%;
  left: 10%;
  margin-left: -70px;
  font-size: 1.1rem;
}

.call .contact-details::after {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent transparent black transparent;
}

.call:hover .contact-details {
  visibility: visible;
}

.info {
  font-size: 2.2rem;
}

.go-back-info {
  display: none;
}

.info-block {
  background-color: #fff;
  border-left: 0.05rem solid #e7e7e7;
  width: 30%;
  height: 95%;
  position: absolute;
  right: 0;
  top: 3.2rem;
  padding: 1rem 0;
  overflow: auto;
  text-align: center;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.09);
}

.info-block div {
  border-bottom: 0.05rem solid #e7e7e7;
  padding: 0.5rem;
}

.info-block h3 {
  text-align: center;
  color: var(--main-blue);
  margin: 0.2rem 0;
}

.grayed {
  color: gray;
  font-weight: 500;
}

.reded {
  text-decoration: line-through;
  color: red;
  opacity: 0.6;
}

.go-back-info {
  padding-left: 1rem;
  font-size: 1.5rem;
  display: block;
  text-align: left;
  position: fixed;
  color: var(--main-light-blue);
  cursor: pointer;
}

.info-image {
  width: 35%;
  margin: 0 auto;
  border: none;
}

.info-image img {
  width: 100%;
  border-radius: 50%;
  border: none;
}

.info-name {
  text-align: center;
  padding-bottom: 1rem;
  border-bottom: 0.05rem solid #eeeeee;
}

.dev {
  color: gray;
  font-size: 0.9rem;
  margin-top: 0.2rem;
}

.map {
  font-size: 0.9rem;
  margin-top: 0.5rem;
  color: black;
}

.gray-dot {
  color: gray;
  margin-left: 1rem;
}

.gray-dot,
.black-dot {
  font-size: 0.9rem;
}

.chatbox {
  width: 100%;
  position: fixed;
  top: 10rem;
  padding: 1rem 2rem;
  overflow: auto;
  height: 70%;
  font-weight: 400;
}

.my-projects {
  width: 100%;
  margin: 2rem auto;
  display: grid;
  grid-template-columns: 28% 28% 28%;
  display: none;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  margin: 1rem 1rem;
  cursor: pointer;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
  background-color: rgba(0, 0, 0, 0.2);
}

.card a {
  text-decoration: none;
  color: #000;
}

.container {
  padding: 0.5rem 1rem;
  text-align: center;
}

.first-msg {
  display: none;
}

.left-msg {
  padding: 1.2rem 1.8rem;
  margin: 0.5rem  0.5rem 2rem;
  background-color: #f1f0f0;
  max-width: 50%;
  text-align: left;
  border-radius: 5rem;
  color:#000;
  font-weight: lighter;
  line-height: 1.2;
  float:left;
  font-size: 1.1rem;
  
}

.left-msg-block {
  padding: 1.2rem 1.8rem;
  margin: 0.5rem auto 0.5rem 2rem;
  background-color: #f1f0f0;
  max-width: 50%;
  text-align: left;
  border-radius: 5rem;
  font-weight: lighter;
  line-height: 1.2;
  font-size: 1.1rem;
  display: table;
  position: relative;
}



.work-related {
  padding: 1rem;
  width: 100%;
  display: grid;
  grid-gap: 0.5rem;
  grid-template-columns: auto auto;
}

.baloon {
  background-color: #237548;
  color: #ffff;
  padding: 1rem;
  font-size: 1.2rem;
  border: none;
  border-radius: 5rem;
  outline: none;
  cursor: pointer;
  text-align: left;
}
::placeholder{
  color: #ccc;
}

.baloon-disabled {
  background-color: black;
  opacity: 0.2;
  color: #ffff;
  padding: 1rem;
  font-size: 1.2rem;
  border: none;
  border-radius: 5rem;
  outline: none;
}




  .right-msg {
    padding: 1rem;
    margin: 0.5rem 0.5rem 0.6rem auto;
    max-width: 92%;
    line-height: 1.1;
    font-size: 1rem;
  }

  .time-left {
    font-size: 0.8rem;
  }

  .img-left {
    width: 2rem;
    font-size: 0.9rem;
  }

  .theimg {
    width: 80%;
    border-radius: 50%;
  }

  .right-msg-emoji {
    margin: 0.5rem 0 0.5rem auto;
    font-size: 2rem;
  }

  .left-msg-emoji {
    margin: 0.5rem auto 0.5rem 0;
    line-height: 0.1;
    font-size: 3rem;
  }

  .thumb-right {
    margin: 0.6rem 0.5rem 0.6rem auto;
    font-size: 1.8rem;
  }

  .polaroid img {
    width: 35%;
    border-radius: 5px;
  }

  .message-section {
    grid-template-columns: 10% auto 10% 10%;
    padding: 0.5rem;
    font-size: 2rem;
    grid-gap: 0.5rem;
  }

  .msg {
    padding: 0.65rem 0.9rem;
    font-size: 1.3rem;
  }
  .green-dot {
  font-size: 0.6rem;
  color: #42b72a;
}
 .green-dot {
    margin-top: 0.2rem;
    font-size: 0.7rem;
  }
  

  .question-block {
    width: 100%;
    height: 20rem;
    margin: 0 auto;
    bottom: 1rem;
    left: 0;
    right: 0;
    padding: 1.5rem;
  }

  .go-back-question {
    padding: 0.4rem 0.7rem;
    font-size: 1.4rem;
    display: block;
    text-align: center;
    position: fixed;
    color: var(--main-light-blue);
    bottom: 1rem;
    right: 1rem;
    background-color: #fff;
    border-radius: 3rem;
    border: 0.05rem solid gray;
  }

  
}

  </style>

                                      <div class="form-group" style="display:none">
       <input type="text" id="lat" name="lat"  placeholder="Lat"  style=" text-align:left; background:transparent; height:60px; color:#15579f; border:none; font-size:18px; font-family: 'Lato', sans-serif;border:none !important;display:none ">     
      <label for="input" class="control-label" style="text-align:left">Latitud</label><i class="bar"></i>
    </div>
    
                                      <div class="form-group" style="display:none">
       <input type="text" id="long" name="long"  placeholder="Long"  style=" text-align:left; background:transparent; height:60px; color:#15579f; border:none; font-size:18px; font-family: 'Lato', sans-serif;border:none !important;display:none  ">     
      <label for="input" class="control-label" style="text-align:left">Longitud</label><i class="bar"></i>
    </div>
<br><br><br><br>
<br><br><br><br>

  <!--fin Vendor JS Files -->
  
<br><br><br><br>
  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>


</body>

</html>
