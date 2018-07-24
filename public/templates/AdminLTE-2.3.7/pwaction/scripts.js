/*
 * implemente seus seus scripts pessoais aqui!
 * todos os addEventListener functions aqui
 *
 */

$('#setLocalStorage').click(function () {
  id = "localStor_01";
  value = document.getElementById("localStorageInput").value;
  // var global;
  fun = getFileContent('script02.js');
  values = {
              'id':value,
              'fun':fun,
              'arr':[1,2,'sao',5],
              'depois':{
                'd':55,
                'pois':99
              }
            };
  // console.log(values.fun);
  setStorage(id, values);
});
$('#getLocalStorage').click(function () {
  id = "localStor_01";
  output = "resp_local";
  resp = getStorage(id);
  if (resp) {
    if (isObject(resp)) {
      functions=resp.fun;
      fun = new Function('string','iddiv', functions);
      fun('funciona', 'resp_session');
    } else {
      document.getElementById(output).value = resp;
    }
  } else {
    document.getElementById(output).value = "erro";
  }
});

$('#startWorker').click(function () {
  var workPath="pwa/webworkers/tester.js";
  startSimpleWorker(workPath, 'print');
});

$('#startWorkerWithStorage').click(function () {
  var workPath="pwa/webworkers/workerWithStorage.js";
  startSimpleWorker(workPath, 'print_wws');
});
