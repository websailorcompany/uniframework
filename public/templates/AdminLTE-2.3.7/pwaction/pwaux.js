/* Funções pwaction
 *
 *
 *
 *
 */

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

// function cyclicsCleaner() {
//   var seenObjects = [];
//   return function cleanCyclics(key, obj) {
//     if (obj && typeof obj === 'object') {
//       if (seenObjects.indexOf(obj) !== -1) {
//         return null;
//       }
//       seenObjects.push(obj);
//     }
//     return obj;
//   }
// }
// // generate a cyclic object
// var a = {};
// var b = {
//   cyclic: a
// };
// a.b = b;
//
// console.log(JSON.stringify(a, cyclicsCleaner()));
