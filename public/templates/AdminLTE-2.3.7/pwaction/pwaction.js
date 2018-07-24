/* Pwaction is a websailor library
 * version 0.2
 * 2018 - Michel-Larrosa
 * UM pwaction por dominio
 * cada template tem seus modulos, seus js e css
 * cada template tem seus scriptWorkers e webworkers
 */
pwaction = new Object();
function startSimpleWorker(workerPath, display) {
  var w;
  if(typeof(Worker) !== "undefined"){
    if(typeof(w) == "undefined") {
      w = new Worker(workerPath);
    }
   w.onmessage = function(event) {
     if (event.data.answer == "continue") {
       document.getElementById(display).innerHTML = event.data.dado + event.data.answer;
     }else{
       if (event.data == "finished") {
         w.terminate();
         w = undefined;
       }
     }
   };
 } else {
   document.getElementById("print").innerHTML = "Sorry! No Web Worker support.";
 }
}

function setStorage(varname, data, session = false){
  if (typeof(Storage) !== "undefined") {
    if (isObject(data)) {
      // certifique-se de realizar function.toString()
      data = JSON.stringify(data);
    }
    if (session) {
      sessionStorage.setItem(varname, data);
    } else {
      localStorage.setItem(varname, data);
    }
    return true;
  } else {
    return false; // Sorry! No Web Storage support..
  }
}

function getStorage(varname, session=false){
  var r;
  if (session) {
    r = sessionStorage.getItem(varname);
  }else {
    r = localStorage.getItem(varname);;
  }
  if (isJson(r)) {
    r = JSON.parse(r);
  }
  return r;
}

function includeJs(jsFilePath) {
    var js = document.createElement("script");
    js.type = "text/javascript";
    js.charset = "utf-8";
    js.src = jsFilePath;
    document.head.appendChild(js);
}

function getFileContent(filePath){
  var fileContent;
  var fileRoute = "pwa/pwaction/scriptRepo/"+filePath;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      fileContent = this.responseText;
    }
  }
  xmlhttp.open("GET",fileRoute, true);
  // xmlhttp.setRequestHeader('Content-type', 'text/javascript');
  xmlhttp.send();
  return fileContent;
}

function getNet(filePath){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log('We seem to be online!', event);
      online = true;
    }else{
      console.log('We are likely offline:', event);
    }
  }
  xmlhttp.open("GET",fileRoute, true);
  // xmlhttp.setRequestHeader('Content-type', 'text/javascript');
  xmlhttp.send();
}
function logIntoServer(logPlace){

}
function isJson(str){
  try {
    JSON.parse(str);
  } catch (e) {
    return false
  }
  return true;
}

function isObject(obj){
  var r = (typeof obj == 'object') ? true : false;
  return r;
}

if ( !Array.prototype.forEach ) {
  Array.prototype.forEach = function(fn, scope) {
    for(var i = 0, len = this.length; i < len; ++i) {
      fn.call(scope, this[i], i, this);
    }
  };
}
function stringifyFunction(elemento, indice, array) {
  if (typeof(elemento)=='function') {
    elemento = elemento.toString();
    console.log(indice);
  }
}
function PWAstringfy(obj){
  obj.forEach(stringifyFunction);
}

function eventtester(){
  alert("teste01");
  console.log("teste1");
}

if('querySelector' in document && 'localStorage' in window && 'addEventListener' in window) {
    //verifica se o browser é ou não HTML4|5
    // bootstrap the javascript application
    // codigo da BBC
    // aqui:
    // http://responsivenews.co.uk/post/18948466399/cutting-the-mustard
}
function swcall(swfile = '/sw.js', swscope = '/'){
  if('serviceWorker' in navigator) {
    navigator.serviceWorker.register(swfile, { scope: swscope })
      .then(function(registration) {
            console.log('Service Worker Registered! Scope is ' + registration.scope);
      });
      navigator.serviceWorker.ready.then(function(registration) {
      console.log('Service Worker Ready');
    });
  }
}

// includeJs('pwa/pwaction/pwaux.js');
// includeJs('pwa/pwaction/scripts.js');
