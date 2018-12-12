
var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var videoStream = null;
var preLog = document.getElementById('preLog');


function savetodb()
{
    var  x = document.getElementById("mycanvas");
    var myimage=document.getElementById("picuploaded");
    var canvas = x.getContext('2d');

    var pic = new Image();
    pic.src = myimage.src;
    canvas.drawImage(pic, 0, 0, x.width, x.height)
    // pic.addEventListener("load", function(){canvas.drawImage(pic, 0, 0, x.width, x.height)}, false);

    var imgpng = document.getElementById('overlay').getElementsByTagName('img')[0];
    canvas.globalAlpha = 1;
    canvas.drawImage(imgpng, 30, 130, imgpng.width/2, imgpng.height/2);
    var url = x.toDataURL();

   $.post("postcam.php", { geturl: url }, function(data) {
      $("#retour_ajax").html(data);  
    });

    // var c=document.getElementById("mycanvas");
    // var ctx=c.getContext("2d");
    // // var img=document.getElementById("picuploaded");
    // ctx.drawImage(img, 0, 0);
    // c.width = img.width;
    // var url = c.toDataURL();
 
}

function overlay(id) {
  var divOverlay = document.getElementById('overlay');

  if (divOverlay.hasChildNodes()){
            divOverlay.removeChild(node);
          }

  var refImg = "data/" + id + ".png";
  node = document.createElement('img');
  node.id = "imageoverlay";
  node.src = refImg;
  node.alt = id;
  divOverlay.appendChild(node);
  var myButton = document.getElementById('buttonSnap');
  if (myButton) myButton.disabled = false;
  var myButton = document.getElementById('buttonPost');
  if (myButton) myButton.disabled = false;
}

function post()
{
  var url = canvas.toDataURL();
  $.post("postcam.php", { geturl: url }, function(data) {
      $("#retour_ajax").html(data);  
    });
}

function log(text)
{
  if (preLog) preLog.textContent += ('\n' + text);
  else alert(text);
}

function snapshot()
{
  var imgpng = document.getElementById('overlay').getElementsByTagName('img')[0];
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);
  canvas.getContext('2d').globalAlpha = 1;
  canvas.getContext('2d').drawImage(imgpng, 0, 0);
  myButton = document.getElementById('buttonPost');
  if (myButton) myButton.disabled = false;
}

function noStream()
{
  log('L’accès à la caméra a été refusé !');
}


function gotStream(stream)
{
  videoStream = stream;
  log('Flux vidéo reçu.');
  video.onerror = function ()
  {
    log('video.onerror');
    if (video) stop();
  };
  stream.onended = noStream;
  if (window.webkitURL) video.src = window.webkitURL.createObjectURL(stream);
  else if (video.mozSrcObject !== undefined)
  {//FF18a
    video.mozSrcObject = stream;
    video.play();
  }
  else if (navigator.mozGetUserMedia)
  {//FF16a, 17a
    video.src = stream;
    video.play();
  }
  else if (window.URL) video.src = window.URL.createObjectURL(stream);
  else video.src = stream;
  myButton = document.getElementById('buttonSnap');
  if (myButton) myButton.disabled = true;
  myButton = document.getElementById('buttonPost');
  if (myButton) myButton.disabled = true;

}

function start()
{
  if ((typeof window === 'undefined') || (typeof navigator === 'undefined')) log('Cette page requiert un navigateur Web avec les objets window.* et navigator.* !');
  else if (!(video && canvas)) log('Erreur de contexte HTML !');
  else
  {
    log('Demande d’accès au flux vidéo…');
    if (navigator.getUserMedia) navigator.getUserMedia({video:true}, gotStream, noStream);
    else if (navigator.oGetUserMedia) navigator.oGetUserMedia({video:true}, gotStream, noStream);
    else if (navigator.mozGetUserMedia) navigator.mozGetUserMedia({video:true}, gotStream, noStream);
    else if (navigator.webkitGetUserMedia) navigator.webkitGetUserMedia({video:true}, gotStream, noStream);
    else if (navigator.msGetUserMedia) navigator.msGetUserMedia({video:true, audio:false}, gotStream, noStream);
    else log('getUserMedia() n’est pas disponible depuis votre navigateur !');
  }
}

start();


// function stop()
// {
//   var myButton = document.getElementById('buttonStop');
//   if (myButton) myButton.disabled = true;
//   myButton = document.getElementById('buttonSnap');
//   if (myButton) myButton.disabled = true;
//   if (videoStream)
//   {
//     if (videoStream.stop) videoStream.stop();
//     else if (videoStream.msStop) videoStream.msStop();
//     videoStream.onended = null;
//     videoStream = null;
//   }
//   if (video)
//   {
//     video.onerror = null;
//     video.pause();
//     if (video.mozSrcObject)
//       video.mozSrcObject = null;
//     video.src = "";
//   }
//   myButton = document.getElementById('buttonStart');
//   if (myButton) myButton.disabled = false;
// }